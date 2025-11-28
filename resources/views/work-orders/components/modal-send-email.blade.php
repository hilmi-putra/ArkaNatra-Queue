<!-- Send Email Modal -->
<div id="hs-send-email-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
    tabindex="-1" aria-labelledby="hs-send-email-modal-label">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500
               mt-0 opacity-0 ease-out transition-all md:max-w-4xl md:w-full m-3 md:mx-auto">
        <div
            class="relative flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">

            <!-- Header -->
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-800">
                <h3 id="hs-send-email-modal-label" class="font-bold text-gray-800 dark:text-white">
                    Kirim via Email
                </h3>
                <button type="button"
                    class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                    aria-label="Close" data-hs-overlay="#hs-send-email-modal">
                    <span class="sr-only">Close</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                </button>
            </div>

            <!-- Body -->
            <div class="p-4 sm:p-6 overflow-y-auto">
                <!-- Password Verification -->
                <div class="mb-6">
                    <label for="send-email-password" class="block text-sm font-medium mb-2 dark:text-white">
                        Verifikasi Password
                    </label>
                    <input type="password" id="send-email-password" name="password"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Masukkan password Anda" required>
                    <div id="send-email-password-error" class="hidden text-xs text-red-600 mt-2"></div>
                </div>

                <!-- Email Preview -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-3 dark:text-white">
                        Preview Email:
                    </label>
                    <div
                        class="bg-gray-50 border border-gray-200 rounded-lg p-4 dark:bg-neutral-800 dark:border-neutral-700">
                        <div class="space-y-3 text-sm">
                            <div class="flex">
                                <span class="text-gray-600 dark:text-neutral-400 w-20 shrink-0">Kepada:</span>
                                <span id="email-preview-to" class="font-medium text-gray-800 dark:text-white break-words flex-1">-</span>
                            </div>
                            <div class="flex">
                                <span class="text-gray-600 dark:text-neutral-400 w-20 shrink-0">Subjek:</span>
                                <span id="email-preview-subject"
                                    class="font-medium text-gray-800 dark:text-white break-words flex-1">-</span>
                            </div>
                            <div class="flex items-start">
                                <span class="text-gray-600 dark:text-neutral-400 w-20 shrink-0 mt-1">Isi:</span>
                                <div class="flex-1">
                                    <pre id="email-preview-body" 
                                        class="text-gray-600 dark:text-neutral-400 whitespace-pre-wrap text-xs font-mono bg-white dark:bg-neutral-900 border border-gray-200 dark:border-neutral-700 rounded-lg p-3 max-h-60 overflow-y-auto break-words w-full">-</pre>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Information -->
                <div
                    class="bg-green-50 border border-green-200 rounded-lg p-4 dark:bg-green-900/20 dark:border-green-800">
                    <div class="flex items-start gap-3">
                        <svg class="shrink-0 size-5 text-green-600 dark:text-green-500 mt-0.5"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect width="20" height="16" x="2" y="4" rx="2" />
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                        </svg>
                        <div class="text-sm">
                            <span class="font-semibold text-green-800 dark:text-green-600">Informasi:</span>
                            <p class="text-green-700 dark:text-green-500 mt-1">
                                Setelah verifikasi berhasil, sistem akan membuka Gmail compose dengan subject dan body
                                yang sudah terisi otomatis.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="flex justify-end items-center gap-x-2 py-3 px-4 bg-gray-50 border-t border-gray-200 dark:bg-neutral-950 dark:border-neutral-800">
                <button type="button"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700"
                    data-hs-overlay="#hs-send-email-modal">
                    Batal
                </button>
                <button type="button" id="send-email-submit"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect width="20" height="16" x="2" y="4" rx="2" />
                        <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                    </svg>
                    Buka Gmail
                </button>
            </div>

            <!-- Hidden input untuk workOrder ID -->
            <input type="hidden" id="send-email-workorder-id" value="">
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sendEmailModal = document.getElementById('hs-send-email-modal');
        const submitButton = document.getElementById('send-email-submit');
        const passwordInput = document.getElementById('send-email-password');
        const passwordError = document.getElementById('send-email-password-error');
        const workOrderIdInput = document.getElementById('send-email-workorder-id');

        // Preview elements
        const emailTo = document.getElementById('email-preview-to');
        const emailSubject = document.getElementById('email-preview-subject');
        const emailBody = document.getElementById('email-preview-body');

        // Function to get current role from URL
        function getCurrentRole() {
            const path = window.location.pathname;
            if (path.includes('/admin/')) return 'admin';
            if (path.includes('/production/')) return 'production';
            if (path.includes('/sales/')) return 'sales';
            if (path.includes('/asservice/')) return 'asservice';
            return 'admin'; // default fallback
        }

        // Function to show toast notification
        function showToast(type, message) {
            // Remove existing toast if any
            const existingToast = document.querySelector('.custom-toast');
            if (existingToast) {
                existingToast.remove();
            }

            const toast = document.createElement('div');
            toast.className = `custom-toast fixed top-4 right-4 p-4 rounded-lg text-white z-[100] ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            }`;
            toast.textContent = message;
            document.body.appendChild(toast);
            
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 3000);
        }

        // Event listener untuk tombol yang membuka modal
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('send-email-btn') || 
                (e.target.closest('button') && e.target.closest('button').classList.contains('send-email-btn'))) {
                
                const button = e.target.classList.contains('send-email-btn') ? e.target : e.target.closest('button');
                const workOrderId = button.getAttribute('data-workorder-id');
                
                if (workOrderId) {
                    workOrderIdInput.value = workOrderId;
                    
                    // Reset form state
                    passwordInput.value = '';
                    passwordError.textContent = '';
                    passwordError.classList.add('hidden');
                    emailTo.textContent = '-';
                    emailSubject.textContent = '-';
                    emailBody.textContent = '-';
                    
                    // Pre-load email preview data
                    loadEmailPreview(workOrderId);
                } else {
                    console.error('Work Order ID tidak ditemukan pada tombol');
                }
            }
        });

        // Function to load email preview
        function loadEmailPreview(workOrderId) {
            const role = getCurrentRole();
            const url = `/${role}/work-orders/${workOrderId}/email-data`;
            
            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    emailTo.textContent = data.data.to;
                    emailSubject.textContent = data.data.subject;
                    emailBody.textContent = data.data.body;
                } else {
                    console.error('Gagal memuat preview email:', data.message);
                }
            })
            .catch(error => {
                console.error('Error loading email preview:', error);
            });
        }

        submitButton.addEventListener('click', function() {
            // Reset error
            passwordError.textContent = '';
            passwordError.classList.add('hidden');

            const password = passwordInput.value;
            const workOrderId = workOrderIdInput.value;

            if (!password) {
                passwordError.textContent = 'Password wajib diisi.';
                passwordError.classList.remove('hidden');
                return;
            }

            if (!workOrderId) {
                passwordError.textContent = 'Work Order ID tidak ditemukan. Coba muat ulang halaman.';
                passwordError.classList.remove('hidden');
                return;
            }

            // Disable button and show loading
            const originalButtonHTML = submitButton.innerHTML;
            submitButton.innerHTML = '<span class="animate-spin size-4 border-2 border-white border-t-transparent rounded-full"></span> Memproses...';
            submitButton.disabled = true;

            const role = getCurrentRole();
            const url = `/${role}/work-orders/${workOrderId}/email-data`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    password: password
                })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(errorData => {
                        throw new Error(errorData.message || 'Terjadi kesalahan server');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    const emailData = data.data;

                    // Update preview (sebagai backup)
                    emailTo.textContent = emailData.to;
                    emailSubject.textContent = emailData.subject;
                    emailBody.textContent = emailData.body;

                    // Open Gmail compose in a new tab
                    const gmailUrl = `https://mail.google.com/mail/?view=cm&fs=1&to=${encodeURIComponent(emailData.to)}&su=${encodeURIComponent(emailData.subject)}&body=${encodeURIComponent(emailData.body)}`;
                    window.open(gmailUrl, '_blank');

                    // Close modal
                    const overlay = HSOverlay.getInstance(sendEmailModal);
                    if (overlay) {
                        overlay.hide();
                    }

                    // Show success message
                    showToast('success', 'Gmail compose berhasil dibuka!');
                    
                    // Reset form
                    passwordInput.value = '';
                } else {
                    throw new Error(data.message || 'Terjadi kesalahan');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                passwordError.textContent = error.message || 'Tidak dapat terhubung ke server.';
                passwordError.classList.remove('hidden');
            })
            .finally(() => {
                // Restore button state
                submitButton.innerHTML = originalButtonHTML;
                submitButton.disabled = false;
            });
        });

        // Reset form ketika modal ditutup
        sendEmailModal.addEventListener('close', function() {
            passwordInput.value = '';
            passwordError.textContent = '';
            passwordError.classList.add('hidden');
            workOrderIdInput.value = '';
        });
    });
</script>

<style>
    /* Custom styling untuk pre element */
    #email-preview-body {
        font-family: 'Monaco', 'Menlo', 'Ubuntu Mono', monospace;
        line-height: 1.4;
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: pre-wrap;
        max-height: 240px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 0.75rem;
        font-size: 0.75rem;
    }

    .dark #email-preview-body {
        background-color: #171717;
        border-color: #404040;
        color: #d4d4d4;
    }

    /* Scrollbar styling */
    #email-preview-body::-webkit-scrollbar {
        width: 6px;
    }

    #email-preview-body::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    #email-preview-body::-webkit-scrollbar-thumb {
        background: #c1c1c1;
        border-radius: 3px;
    }

    #email-preview-body::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }

    .dark #email-preview-body::-webkit-scrollbar-track {
        background: #404040;
    }

    .dark #email-preview-body::-webkit-scrollbar-thumb {
        background: #6b6b6b;
    }

    .dark #email-preview-body::-webkit-scrollbar-thumb:hover {
        background: #7d7d7d;
    }
</style>