// Fungsi untuk memeriksa apakah tabel memiliki struktur yang valid
function isTableStructureValid(tableElement) {
    const $table = $(tableElement);

    // Periksa apakah tabel memiliki thead dengan minimal 1 kolom
    const headerCount = $table.find("thead th").length;
    if (headerCount === 0) {
        console.warn(
            "DataTable skipped: Tabel tidak memiliki header kolom",
            tableElement
        );
        return false;
    }

    // Periksa apakah tabel memiliki tbody (even jika kosong)
    const tbody = $table.find("tbody");
    if (tbody.length === 0) {
        console.warn(
            "DataTable skipped: Tabel tidak memiliki tbody",
            tableElement
        );
        return false;
    }

    // Periksa konsistensi kolom pada baris data (jika ada)
    const bodyRows = tbody.find("tr");
    if (bodyRows.length > 0) {
        let isConsistent = true;
        bodyRows.each(function (index) {
            const cellCount = $(this).find("td").length;
            if (cellCount > 0 && cellCount !== headerCount) {
                // Toleransi kecil untuk colspan/rowspan cases
                if (Math.abs(cellCount - headerCount) > 1) {
                    console.warn(
                        `DataTable warning: Baris ${index} memiliki ${cellCount} kolom, tetapi header memiliki ${headerCount}`,
                        tableElement
                    );
                    isConsistent = false;
                }
            }
        });
        if (!isConsistent) {
            return false;
        }
    }

    return true;
}

// Fungsi untuk menginisialisasi DataTables dengan styling Flowbite (dengan pengecekan keamanan)
function initializeDataTables() {
    // Inisialisasi tabel dengan berbagai selector untuk kompatibilitas
    // 1. Cari tabel dengan class "datatable"
    // 2. Cari tabel di dalam div.card dengan structure standard (thead + tbody)
    // 3. Cari tabel dengan class min-w-full (common pattern di app)
    const tableSelectors = [
        "table.datatable",
        "div.card table[class*='min-w-full']",
        "table[class*='divide-y']",
    ];

    const uniqueTables = new Set();
    const tablesToInit = [];

    tableSelectors.forEach((selector) => {
        $(selector).each(function () {
            // Hindari duplicate
            if (!uniqueTables.has(this)) {
                uniqueTables.add(this);
                tablesToInit.push(this);
            }
        });
    });

    console.info(
        `🔍 Ditemukan ${tablesToInit.length} tabel untuk diinisialisasi`
    );

    tablesToInit.forEach((tableElement) => {
        // Langkah 1: Validasi struktur tabel
        if (!isTableStructureValid(tableElement)) {
            console.error(
                "❌ DataTable skip: Struktur tabel tidak valid",
                tableElement
            );
            return; // Skip tabel ini
        }

        // Langkah 2: Cek apakah tabel sudah diinisialisasi sebelumnya
        if ($.fn.DataTable.isDataTable(tableElement)) {
            console.log(
                "⚠️ DataTable sudah diinisialisasi, skip reinisialisasi",
                tableElement
            );
            return; // Skip jika sudah ada
        }

        // Langkah 3: Berikan ID jika tidak ada
        if (!tableElement.id) {
            tableElement.id =
                "datatable-" + Math.random().toString(36).substr(2, 9);
        }

        // Langkah 4: Hitung jumlah kolom untuk colspan
        const columnCount = $(tableElement).find("thead th").length;

        // Langkah 5: Inisialisasi DataTables dengan error handling
        try {
            $(tableElement).DataTable({
                language: {
                    search: "",
                    searchPlaceholder: "Type to search...",
                    lengthMenu: "_MENU_",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous",
                    },
                    emptyTable: generateEmptyStateHTML(columnCount, "no-data"),
                    zeroRecords: generateEmptyStateHTML(
                        columnCount,
                        "no-results"
                    ),
                },

                dom: '<"flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0"<"mb-4 md:mb-0"l><"flex items-center space-x-4"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 mt-6"<"mb-4 md:mb-0"i><"pagination"p>>',
                paging: true,
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, 100],
                    ["10 rows", "25 rows", "50 rows", "100 rows"],
                ],
                searching: true,
                ordering: true,
                info: true,
                stateSave: false,
                serverSide: false,
                responsive: true,
                autoWidth: false,
                retrieve: true,
                destroy: false,
                drawCallback: function () {
                    // Terapkan kembali custom styling setelah setiap draw
                    customizeDataTables(this);

                    // Cek apakah ada custom empty state dan styling ulang
                    styleEmptyState(this);
                },
                initComplete: function () {
                    // Custom styling untuk elemen DataTables setelah inisialisasi
                    customizeDataTables(this);
                },
                error: function (e) {
                    console.error("❌ DataTable initialization error:", e);
                },
            });

            console.log(
                "✅ DataTable berhasil diinisialisasi:",
                tableElement.id
            );
        } catch (error) {
            console.error(
                "❌ DataTable initialization exception:",
                error,
                tableElement
            );
        }
    });
}

// Fungsi untuk generate HTML custom empty state
function generateEmptyStateHTML(columnCount, type) {
    const title =
        type === "no-data"
            ? "No attendance records found"
            : "No matching records found";

    const description =
        type === "no-data"
            ? "Add attendance records to track student presence."
            : "Try adjusting your search to find what you are looking for.";

    return `
        <tr class="dt-empty-state-row">
            <td colspan="${columnCount}" class="!p-6">
                <div class="p-6 flex items-start gap-4">
                    <div class="flex justify-center items-center size-10 bg-gray-100 dark:bg-neutral-800 rounded-lg">
                        <svg class="size-5 text-gray-600 dark:text-neutral-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 16 16">
                            <path
                                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                        </svg>
                    </div>

                    <div>
                        <h2 class="font-semibold text-gray-800 dark:text-white">
                            ${title}
                        </h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-neutral-400">
                            ${description}
                        </p>
                    </div>
                </div>
            </td>
        </tr>

    `.trim();
}

// Fungsi untuk styling empty state setelah render
function styleEmptyState(table) {
    const wrapper = $(table.table().container());
    const emptyStateRow = wrapper.find(".dt-empty-state-row");

    if (emptyStateRow.length > 0) {
        // Hilangkan border dan padding default pada row
        emptyStateRow.css({
            border: "none",
            background: "transparent",
        });

        // Pastikan tidak ada hover effect pada row kosong
        emptyStateRow.removeClass("hover:bg-gray-50 dark:hover:bg-neutral-800");
        emptyStateRow.addClass("!bg-transparent");

        // Hilangkan semua class yang tidak diperlukan dari td
        const emptyCell = emptyStateRow.find("td");
        emptyCell.removeClass(
            "px-6 py-4 text-sm text-gray-800 dark:text-neutral-200"
        );

        // Paksa center alignment
        emptyCell.css({
            "text-align": "center",
            "vertical-align": "middle",
            padding: "0",
            border: "none",
        });

        // Tambahkan min-height pada tbody untuk centering vertikal
        const tbody = wrapper.find("tbody");
        tbody.css({
            "min-height": "400px",
            display: "table-row-group",
        });
    }
}

// Fungsi untuk menyesuaikan styling DataTables dengan Flowbite (dengan pengecekan keamanan)
function customizeDataTables(table) {
    // Cek apakah table valid
    if (!table || !table.table) {
        console.warn("customizeDataTables: Table object tidak valid");
        return;
    }

    const wrapper = $(table.table().container());

    // Jika wrapper kosong, keluar lebih awal
    if (!wrapper || wrapper.length === 0) {
        console.warn("customizeDataTables: Wrapper tidak ditemukan");
        return;
    }

    try {
        // Custom styling untuk search input dengan margin
        const searchInput = wrapper.find(".dataTables_filter input");
        if (searchInput.length) {
            searchInput.attr(
                "class",
                "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block p-2.5 dark:bg-neutral-700 dark:border-neutral-600 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
            );
            searchInput.attr("placeholder", "Type to search...");

            // Tambahkan ikon pencarian dan margin
            const searchContainer = wrapper.find(".dataTables_filter");

            // Cek apakah ikon sudah ada untuk menghindari duplikasi
            if (!searchContainer.find(".search-icon-wrapper").length) {
                const searchInputElement = searchInput[0].outerHTML;
                searchContainer.html(`
                    <div class="relative ml-4 search-icon-wrapper">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-neutral-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        ${searchInputElement}
                    </div>
                `);

                // Update class untuk input dengan padding kiri untuk ikon
                const newSearchInput = wrapper.find(".dataTables_filter input");
                newSearchInput.attr(
                    "class",
                    "bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-orange-500 focus:border-orange-500 block pl-10 p-2.5 dark:bg-neutral-700 dark:border-neutral-600 dark:placeholder-neutral-400 dark:text-white dark:focus:ring-orange-500 dark:focus:border-orange-500"
                );
            }

            // Tambahkan margin untuk container search
            searchContainer.addClass("mb-4");
        }

        // Custom styling untuk pagination dengan margin
        const pagination = wrapper.find(".dataTables_paginate");
        if (pagination.length) {
            pagination.attr("class", "inline-flex mt-4 md:mt-0 space-x-2");

            const paginateButtons = pagination.find(".paginate_button");
            paginateButtons.each(function () {
                const button = $(this);
                let baseClass =
                    "paginate_button inline-flex items-center justify-center gap-2 px-3 py-2 text-sm font-medium rounded-lg mx-1";

                if (button.hasClass("current")) {
                    button.attr(
                        "class",
                        baseClass +
                            " text-white bg-orange-600 border border-orange-600 hover:bg-orange-700 hover:text-white dark:bg-orange-500 dark:border-orange-500 dark:hover:bg-orange-600"
                    );
                } else if (button.hasClass("disabled")) {
                    button.attr(
                        "class",
                        baseClass +
                            " text-gray-300 bg-white border border-gray-200 cursor-not-allowed dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-500"
                    );
                } else {
                    button.attr(
                        "class",
                        baseClass +
                            " text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-white"
                    );
                }
            });

            // Tambahkan margin untuk container pagination
            pagination.addClass("my-4");
        }

        // Custom styling untuk header tabel (skip untuk empty state)
        const tableHeaders = wrapper.find("thead th");
        tableHeaders.each(function () {
            const header = $(this);
            if (!header.hasClass("custom-styled")) {
                header.addClass(
                    "custom-styled px-6 py-3 text-start text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200 bg-gray-50 dark:bg-neutral-900"
                );
            }
        });

        // Custom styling untuk baris tabel (skip untuk empty state)
        const tableRows = wrapper.find("tbody tr");
        tableRows.each(function () {
            const row = $(this);
            if (
                !row.hasClass("dt-empty-state-row") &&
                !row.hasClass("custom-styled-row")
            ) {
                row.addClass(
                    "custom-styled-row bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800"
                );
            }
        });

        // Custom styling untuk sel tabel (skip untuk empty state)
        const tableCells = wrapper.find("tbody td");
        tableCells.each(function () {
            const cell = $(this);
            const parentRow = cell.closest("tr");

            if (
                !parentRow.hasClass("dt-empty-state-row") &&
                !cell.hasClass("whitespace-nowrap") &&
                !cell.hasClass("custom-styled-cell")
            ) {
                cell.addClass(
                    "custom-styled-cell px-6 py-4 text-sm text-gray-800 dark:text-neutral-200"
                );
            }
        });

        // Tambahkan margin untuk wrapper controls atas
        const topControls = wrapper.find(".dataTables_wrapper > .flex").first();
        if (
            topControls.length &&
            !topControls.hasClass("custom-styled-controls")
        ) {
            topControls.addClass(
                "custom-styled-controls mb-6 p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg"
            );
        }

        // Tambahkan margin untuk wrapper controls bawah
        const bottomControls = wrapper
            .find(".dataTables_wrapper > .flex")
            .last();
        if (
            bottomControls.length &&
            !bottomControls.is(topControls) &&
            !bottomControls.hasClass("custom-styled-controls")
        ) {
            bottomControls.addClass(
                "custom-styled-controls mt-6 p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg"
            );
        }
    } catch (error) {
        console.warn("Error in customizeDataTables:", error);
    }
}

// Fungsi untuk deteksi dan filter tabel yang perlu DataTables
function detectDataTables() {
    // Cari tabel dengan berbagai pattern
    const patterns = [
        "table.datatable",
        "div.card table[class*='min-w-full']",
        "table[class*='divide-y']",
    ];

    let totalFound = 0;
    patterns.forEach((pattern) => {
        totalFound += $(pattern).length;
    });

    if (totalFound === 0) {
        console.info(
            "ℹ️ Tidak ada tabel dengan pattern datatable ditemukan di halaman ini"
        );
        return false;
    }

    console.info(
        `🔍 Ditemukan ${totalFound} tabel untuk inisialisasi DataTables`
    );
    return true;
}

// Fungsi untuk reinisialisasi DataTables ketika ada perubahan DOM (untuk AJAX/dinamis content)
function reinitializeDataTables() {
    // Hancurkan DataTable yang sudah ada
    $.fn.dataTable.tables({ visible: true, api: true }).destroy();

    // Reinisialisasi semua tabel
    initializeDataTables();
}

// Fungsi untuk menyimpan state DataTables (pagination, search, dll)
function saveDataTableState() {
    try {
        const tables = $.fn.dataTable.tables({ api: true });
        tables.each(function () {
            const tableId = $(this.table().node()).attr("id");
            if (tableId) {
                const state = this.state();
                localStorage.setItem(
                    `datatable_state_${tableId}`,
                    JSON.stringify(state)
                );
            }
        });
        console.log("DataTable state tersimpan");
    } catch (error) {
        console.warn("Gagal menyimpan DataTable state:", error);
    }
}

// Inisialisasi saat dokumen siap
$(document).ready(function () {
    // Bersihkan localStorage state lama (jika ada)
    try {
        const keysToDelete = [];
        for (let i = 0; i < localStorage.length; i++) {
            const key = localStorage.key(i);
            if (
                key &&
                (key.includes("datatable_state") || key.includes("DataTables_"))
            ) {
                keysToDelete.push(key);
            }
        }
        keysToDelete.forEach((key) => localStorage.removeItem(key));
        if (keysToDelete.length > 0) {
            console.log(
                `🧹 Dibersihkan ${keysToDelete.length} legacy DataTable state entries`
            );
        }
    } catch (error) {
        console.warn("Warning: Could not clean localStorage", error);
    }

    // Deteksi keberadaan tabel DataTables
    if (detectDataTables()) {
        initializeDataTables();
    }

    // Simpan state sebelum halaman ditinggalkan
    $(window).on("beforeunload", function () {
        saveDataTableState();
    });
});

// Support untuk reinisialisasi dinamis (jika ada AJAX loading content)
$(document).on("datatables:reinit", function () {
    console.log("Memicu reinisialisasi DataTables");
    reinitializeDataTables();
});
