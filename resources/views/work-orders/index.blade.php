@extends('layouts.app')

@section('content')
    <!-- Page Wrapper -->
    <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14">

        <!-- Card Wrapper -->
        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-2xs overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">

                        <!-- Header -->
                        <div
                            class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                            <div>
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">Work Orders</h2>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">Daftar Work Order lengkap beserta
                                    relasinya.</p>
                            </div>

                            <div class="flex justify-end gap-x-2">
                                <!-- Filter Dropdown -->
                                <div class="hs-dropdown [--placement:bottom-right] relative inline-block"
                                    data-hs-dropdown-auto-close="outside">
                                    <button id="hs-as-table-table-filter-dropdown" type="button"
                                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                                        <svg class="shrink-0 size-3.5 text-gray-800 dark:text-neutral-200"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 6h18" />
                                            <path d="M7 12h10" />
                                            <path d="M10 18h4" />
                                        </svg>
                                        Filter
                                        <span id="filter-count"
                                            class="hidden inline-flex items-center gap-1.5 py-0.5 px-1.5 rounded-full text-xs font-medium border border-gray-300 text-gray-800 dark:border-neutral-700 dark:text-neutral-300">0</span>
                                    </button>
                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-48 z-20 bg-white shadow-md rounded-lg mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700"
                                        role="menu">
                                        <div class="p-4">
                                            <div class="mb-4">
                                                <label for="filter-status"
                                                    class="block text-sm font-medium mb-2 dark:text-white">Status</label>
                                                <select id="filter-status"
                                                    class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                    <option value="">All</option>
                                                    <option value="validate">Validate</option>
                                                    <option value="queue">Queue</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="progress">Progress</option>
                                                    <option value="revision">Revision</option>
                                                    <option value="migration">Migration</option>
                                                    <option value="finish">Finish</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label for="filter-fast-track"
                                                    class="block text-sm font-medium mb-2 dark:text-white">Fast
                                                    Track</label>
                                                <select id="filter-fast-track"
                                                    class="py-2 px-3 pe-9 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400">
                                                    <option value="">All</option>
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="p-2 border-t border-gray-200 dark:border-neutral-700">
                                            <button id="apply-filters" type="button"
                                                class="w-full py-2 px-3 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                                Apply Filters
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @role('asservice')
                                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                        href="{{ route('asservice.work-orders.create') }}">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                        </svg>
                                        Tambah Work Order
                                    </a>
                                @endrole
                            </div>
                        </div>
                        <!-- End Header -->

                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="ps-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">No</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Ref
                                                ID</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Antrian
                                                Ke</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Customer</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Marketing
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Production
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Status</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Qty</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Estimasi</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Fast
                                                Track</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Tgl
                                                Diterima</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Tgl
                                                Selesai</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-end">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Aksi</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                @include('work-orders.partials.table-rows', ['data' => $data])
                            </tbody>
                        </table>
                        <!-- End Table -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->

    </div>
    <!-- End Page Wrapper -->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fungsi untuk menyalin teks ke clipboard
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    // Show success message (optional)
                    console.log('Text copied to clipboard successfully!');

                    // Anda bisa menambahkan toast notification di sini
                    // Contoh: showToast('Info berhasil disalin ke clipboard!', 'success');
                }).catch(function(err) {
                    console.error('Failed to copy text: ', err);

                    // Fallback untuk browser lama
                    const textArea = document.createElement('textarea');
                    textArea.value = text;
                    document.body.appendChild(textArea);
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        console.log('Text copied to clipboard using fallback!');
                    } catch (err) {
                        console.error('Fallback copy failed: ', err);
                    }
                    document.body.removeChild(textArea);
                });
            }

            // Event listener untuk tombol copy
            document.querySelectorAll('.copy-customer-info-btn').forEach(function(button) {
                button.addEventListener('click', function() {
                    const refId = this.getAttribute('data-ref-id');
                    const token = this.getAttribute('data-token');
                    const baseUrl = this.getAttribute('data-url');

                    // Format pesan profesional
                    const message =
                        `Untuk melihat status antrian pekerjaan Anda, silakan kunjungi website kami di ${baseUrl} dan gunakan Ref ID: ${refId} serta Token: ${token}`;

                    // Salin ke clipboard
                    copyToClipboard(message);

                    // Optional: Tambahkan feedback visual
                    const originalHtml = this.innerHTML;
                    this.innerHTML = `
                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                </svg>
                Disalin!
            `;

                    // Kembalikan ke state semula setelah 2 detik
                    setTimeout(() => {
                        this.innerHTML = originalHtml;
                    }, 2000);
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Existing script for status update, now with SweetAlert
            document.body.addEventListener('click', function(e) {
                if (e.target.closest('.status-update-btn')) {
                    e.preventDefault();
                    const button = e.target.closest('.status-update-btn');
                    const orderId = button.getAttribute('data-order-id');
                    const newStatus = button.getAttribute('data-status');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content');

                    // Get status display name for better message
                    const statusNames = {
                        'validate': 'Validate',
                        'queue': 'Queue',
                        'pending': 'Pending',
                        'progress': 'Progress',
                        'revision': 'Revision',
                        'migration': 'Migration',
                        'finish': 'Finish'
                    };

                    const statusName = statusNames[newStatus] || newStatus;

                    // Show loading alert
                    Swal.fire({
                        title: 'Updating Status...',
                        text: `Changing status to ${statusName}`,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    fetch(`/production/work-orders/${orderId}/status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                status: newStatus
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                // Success alert
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: data.message || 'Status updated successfully!',
                                    timer: 2000,
                                    showConfirmButton: false,
                                    willClose: () => {
                                        window.location.reload();
                                    }
                                });
                            } else {
                                // Error alert from server
                                throw new Error(data.message || 'Unknown error occurred');
                            }
                        })
                        .catch(error => {
                            console.error('There was an error updating status!', error);

                            // Error alert
                            Swal.fire({
                                icon: 'error',
                                title: 'Update Failed!',
                                text: error.message ||
                                    'An unexpected error occurred during status update.',
                                confirmButtonText: 'OK',
                                confirmButtonColor: '#d33'
                            });
                        });
                }
            });

            // Existing filter code remains the same
            const applyFiltersBtn = document.getElementById('apply-filters');
            const statusFilter = document.getElementById('filter-status');
            const fastTrackFilter = document.getElementById('filter-fast-track');
            const tableBody = document.querySelector('tbody');
            const filterCount = document.getElementById('filter-count');
            const filterDropdownButton = document.getElementById('hs-as-table-table-filter-dropdown');
            const filterDropdownContent = document.querySelector('.hs-dropdown [role="menu"]');

            // Prevent dropdown close when clicking inside dropdown content
            if (filterDropdownContent) {
                filterDropdownContent.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            }

            // Prevent dropdown close when interacting with select elements
            [statusFilter, fastTrackFilter].forEach(select => {
                select.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });

            applyFiltersBtn.addEventListener('click', function(e) {
                e.stopPropagation();

                const status = statusFilter.value;
                const fastTrack = fastTrackFilter.value;
                let filtersApplied = 0;

                const url = new URL('{{ route(request()->route()->getName()) }}');

                if (status) {
                    url.searchParams.set('status', status);
                    filtersApplied++;
                }
                if (fastTrack !== '') {
                    url.searchParams.set('fast_track', fastTrack);
                    filtersApplied++;
                }

                if (filtersApplied > 0) {
                    filterCount.textContent = filtersApplied;
                    filterCount.classList.remove('hidden');
                } else {
                    filterCount.classList.add('hidden');
                }

                tableBody.innerHTML =
                    `<tr><td colspan="13" class="text-center py-4"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...</td></tr>`;

                fetch(url.toString(), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        tableBody.innerHTML = data.html;
                        setTimeout(() => window.HSStaticMethods.autoInit(), 100);

                        // Close dropdown setelah data berhasil dimuat
                        const dropdownInstance = HSDropdown.getInstance(filterDropdownButton
                            .parentElement);
                        if (dropdownInstance) {
                            dropdownInstance.close();
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching filtered data:', error);
                        tableBody.innerHTML =
                            `<tr><td colspan="13" class="text-center py-4 text-red-500">Error loading data. Please try again.</td></tr>`;
                    });
            });
        });
    </script>
@endsection
