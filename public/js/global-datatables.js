// Fungsi untuk menginisialisasi DataTables dengan styling Flowbite
function initializeDataTables() {
    // Inisialisasi semua tabel di halaman
    $("table").each(function () {
        // Cek apakah tabel sudah memiliki ID, jika tidak berikan ID
        if (!this.id) {
            this.id = "datatable-" + Math.random().toString(36).substr(2, 9);
        }

        // Hitung jumlah kolom untuk colspan
        const columnCount = $(this).find("thead th").length;

        // Inisialisasi DataTables
        $(this).DataTable({
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
                zeroRecords: generateEmptyStateHTML(columnCount, "no-results"),
            },

            dom: '<"flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0"<"mb-4 md:mb-0"l><"flex items-center space-x-4"f>>rt<"flex flex-col md:flex-row md:items-center md:justify-between space-y-4 md:space-y-0 mt-6"<"mb-4 md:mb-0"i><"pagination"p>>',
            initComplete: function () {
                // Custom styling untuk elemen DataTables setelah inisialisasi
                customizeDataTables(this);
            },
            drawCallback: function () {
                // Terapkan kembali custom styling setelah setiap draw
                customizeDataTables(this);

                // Cek apakah ada custom empty state dan styling ulang
                styleEmptyState(this);
            },
        });
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

// Fungsi untuk menyesuaikan styling DataTables dengan Flowbite
function customizeDataTables(table) {
    const wrapper = $(table.table().container());

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

    // Custom styling untuk length select dengan HS Dropdown style
    // Custom styling untuk length select dengan HS Dropdown style
    const lengthSelect = $('#search-table_length').find("select");
    if (lengthSelect.length) {
        // Tambahkan wrapper relatif agar bisa tempatkan dropdown custom
        const lengthContainer = $('#search-table_length');
        lengthContainer.addClass("relative inline-flex items-center mb-4 mr-4");

        // Ambil semua opsi dari select bawaan DataTables
        const options = lengthSelect.find("option").map(function () {
            return {
                value: $(this).val(),
                text: $(this).text()
            };
        }).get();

        // Ambil nilai yang sedang aktif
        const currentValue = lengthSelect.val();

        // Hapus select bawaan agar diganti dengan HS Dropdown custom
        lengthSelect.remove();

        // Tambahkan HTML HS Dropdown menggantikan select
        lengthContainer.html(`
            <div class="hs-dropdown [--strategy:absolute] relative inline-flex">
                <button id="hs-table-length" type="button"
                    class="flex justify-center items-center gap-x-3 px-3 py-2 text-sm text-gray-600 bg-gray-50 hover:bg-gray-100 rounded-lg border border-gray-300 dark:text-neutral-400 dark:bg-neutral-800 dark:border-neutral-700 dark:hover:bg-neutral-700">
                    <span id="selected-length">${currentValue}</span>
                    <svg class="shrink-0 size-4.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m6 9 6 6 6-6" />
                    </svg>
                </button>

                <div class="hs-dropdown-menu hs-dropdown-open:opacity-100 w-32 transition-[opacity,margin] duration opacity-0 hidden z-10 bg-white border border-gray-200 rounded-xl shadow-lg before:absolute before:-top-4 before:start-0 before:w-full before:h-5 dark:bg-neutral-950 dark:border-neutral-700"
                    role="menu" aria-orientation="vertical" aria-labelledby="hs-table-length">
                    <div class="p-1 space-y-0.5">
                        ${options
                            .map(
                                opt => `
                            <button type="button"
                                class="length-option w-full flex items-center gap-x-3 py-1.5 px-2 rounded-lg text-sm text-gray-800 hover:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-800 ${
                                    opt.value == currentValue
                                        ? "bg-gray-100 dark:bg-neutral-800"
                                        : ""
                                }"
                                data-length="${opt.value}">
                                ${opt.text}
                            </button>
                        `
                            )
                            .join("")}
                    </div>
                </div>
            </div>
        `);

        // Event handler untuk klik opsi dropdown
        lengthContainer.on("click", ".length-option", function () {
            const newLength = $(this).data("length");
            const table = $("#search-table").DataTable(); // ganti sesuai ID tabel kamu
            table.page.len(newLength).draw();

            // Update label dropdown
            $("#selected-length").text(newLength);

            // Tutup dropdown manual (jika HS belum otomatis)
            $(this)
                .closest(".hs-dropdown-menu")
                .addClass("hidden")
                .removeClass("opacity-100");
        });
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
    if (topControls.length && !topControls.hasClass("custom-styled-controls")) {
        topControls.addClass(
            "custom-styled-controls mb-6 p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg"
        );
    }

    // Tambahkan margin untuk wrapper controls bawah
    const bottomControls = wrapper.find(".dataTables_wrapper > .flex").last();
    if (
        bottomControls.length &&
        !bottomControls.is(topControls) &&
        !bottomControls.hasClass("custom-styled-controls")
    ) {
        bottomControls.addClass(
            "custom-styled-controls mt-6 p-4 bg-gray-50 dark:bg-neutral-800 rounded-lg"
        );
    }
}

// Inisialisasi saat dokumen siap
$(document).ready(function () {
    initializeDataTables();
});
