<!-- Delete Work Order Modal -->
<div id="hs-delete-workorder-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
    tabindex="-1" aria-labelledby="hs-delete-workorder-modal-label">

    <!-- WRAPPER utama Preline -->
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500
               mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">

        <div
            class="relative flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">

            <div class="absolute top-2 end-2">
                <button type="button"
                    class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                    aria-label="Close" data-hs-overlay="#hs-delete-workorder-modal">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-4 sm:p-10 overflow-y-auto">
                <div class="flex gap-x-4 md:gap-x-7">

                    <span
                        class="shrink-0 inline-flex justify-center items-center size-11 sm:w-15.5 sm:h-15.5 rounded-full border-4 border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100">
                        <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                        </svg>
                    </span>

                    <div class="grow">
                        <h3 id="hs-delete-workorder-modal-label"
                            class="mb-2 text-xl font-bold text-gray-800 dark:text-neutral-200">
                            Konfirmasi Penghapusan Work Order
                        </h3>
                        <p class="text-gray-500 dark:text-neutral-500 mb-4">
                            Apakah Anda yakin ingin menghapus work order berikut?
                        </p>

                        <div class="text-sm bg-gray-50 dark:bg-neutral-800 p-4 rounded-lg mb-4 space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-neutral-400 font-medium">Ref ID:</span>
                                <span class="font-semibold text-gray-800 dark:text-neutral-200"
                                    id="modal-workorder-refid">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-neutral-400 font-medium">Customer:</span>
                                <span class="font-medium text-gray-800 dark:text-neutral-200"
                                    id="modal-workorder-customer">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-neutral-400 font-medium">Divisi:</span>
                                <span class="font-medium text-blue-600 dark:text-blue-400"
                                    id="modal-workorder-division">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-neutral-400 font-medium">Jenis Pekerjaan:</span>
                                <span class="font-medium text-gray-800 dark:text-neutral-200"
                                    id="modal-workorder-worktype">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-neutral-400 font-medium">Status:</span>
                                <span class="font-medium" id="modal-workorder-status">—</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-gray-600 dark:text-neutral-400 font-medium">Antrian:</span>
                                <span class="font-medium text-orange-600 dark:text-orange-400"
                                    id="modal-workorder-queue">—</span>
                            </div>
                        </div>

                        <div
                            class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 dark:bg-yellow-900/20 dark:border-yellow-800">
                            <div class="flex items-start gap-3">
                                <svg class="shrink-0 size-5 text-yellow-600 dark:text-yellow-500 mt-0.5"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                                    <path d="M12 9v4" />
                                    <path d="M12 17h.01" />
                                </svg>
                                <div class="text-sm">
                                    <span class="font-semibold text-yellow-800 dark:text-yellow-600">Peringatan:</span>
                                    <p class="text-yellow-700 dark:text-yellow-500 mt-1">
                                        Semua data work order, akses credentials, dan file terkait akan dihapus secara
                                        permanen dan tidak dapat dikembalikan.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <form id="delete-workorder-form" method="POST" action="">
                @csrf
                @method('DELETE')
                <input type="hidden" name="workorder_id" id="workorder-id-input">

                <div
                    class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t border-gray-200 dark:bg-neutral-950 dark:border-neutral-800">
                    <button type="button"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50"
                        data-hs-overlay="#hs-delete-workorder-modal">
                        Batal
                    </button>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg bg-red-500 text-white hover:bg-red-600">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" viewBox="0 0 16 16">
                            <path
                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Z" />
                        </svg>
                        Hapus Permanen
                    </button>
                </div>
            </form>

        </div>

    </div>
</div>

<script>
    window.addEventListener('load', () => {
        // Preline UI initialization
        setTimeout(() => {
            if (window.HSStaticMethods) {
                window.HSStaticMethods.autoInit();
            }
        }, 100);

        // Logic to handle delete modal data
        const deleteButtons = document.querySelectorAll('.delete-workorder-btn');
        const modalRefId = document.getElementById('modal-workorder-refid');
        const modalCustomer = document.getElementById('modal-workorder-customer');
        const modalDivision = document.getElementById('modal-workorder-division');
        const modalWorkType = document.getElementById('modal-workorder-worktype');
        const modalStatus = document.getElementById('modal-workorder-status');
        const modalQueue = document.getElementById('modal-workorder-queue');
        const deleteForm = document.getElementById('delete-workorder-form');
        const workorderIdInput = document.getElementById('workorder-id-input');

        deleteButtons.forEach(button => {
            button.addEventListener('click', () => {
                const workorderId = button.getAttribute('data-workorder-id');
                const refId = button.getAttribute('data-ref-id');
                const customer = button.getAttribute('data-customer');
                const division = button.getAttribute('data-division');
                const workType = button.getAttribute('data-worktype');
                const status = button.getAttribute('data-status');
                const queue = button.getAttribute('data-queue');

                // Populate modal with work order data
                modalRefId.textContent = refId;
                modalCustomer.textContent = customer;
                modalDivision.textContent = division;
                modalWorkType.textContent = workType;
                modalQueue.textContent = `#${queue}`;
                workorderIdInput.value = workorderId;

                // Set status dengan badge styling
                const statusMap = {
                    'validate': {
                        text: 'Validasi',
                        class: 'bg-green-100 text-green-800'
                    },
                    'pending': {
                        text: 'Pending',
                        class: 'bg-yellow-100 text-yellow-800'
                    },
                    'completed': {
                        text: 'Selesai',
                        class: 'bg-blue-100 text-blue-800'
                    },
                    'revision': {
                        text: 'Revisi',
                        class: 'bg-red-100 text-red-800'
                    },
                    'in_progress': {
                        text: 'Dalam Proses',
                        class: 'bg-purple-100 text-purple-800'
                    }
                };

                const statusInfo = statusMap[status] || {
                    text: status,
                    class: 'bg-gray-100 text-gray-800'
                };
                modalStatus.innerHTML =
                    `<span class="px-2 py-1 text-xs font-medium rounded-full ${statusInfo.class}">${statusInfo.text}</span>`;

                // Set the form action URL
                let baseUrl = "{{ url('asservice/work-orders') }}";
                deleteForm.action = `${baseUrl}/${workorderId}`;
            });
        });
    });
</script>
