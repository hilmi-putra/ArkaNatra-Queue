<!-- Cancel Confirmation Modal -->
<div id="hs-cancel-confirmation-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
    role="dialog" tabindex="-1" aria-labelledby="hs-cancel-modal-label">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500
               mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div
            class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 transition-all duration-300 sm:max-w-lg sm:w-full sm:mx-auto sm:my-6 sm:relative absolute top-1/2 start-1/2 transform -translate-x-1/2 -translate-y-1/2">
            <!-- Modal Content -->
            <div class="w-full bg-white rounded-lg shadow-2xl dark:bg-neutral-900">
                <!-- Modal Header -->
                <div
                    class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                    <h3 id="hs-cancel-modal-label" class="text-lg font-semibold text-gray-800 dark:text-neutral-200">
                        Konfirmasi Pembatalan Work Order
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center size-8 text-gray-400 hover:text-gray-600 focus:outline-hidden dark:hover:text-neutral-300 transition-colors"
                        data-hs-overlay="#hs-cancel-confirmation-modal" aria-label="Close">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6l-12 12M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4 space-y-4">
                    <!-- Warning Alert -->
                    <div
                        class="p-4 bg-red-50 border border-red-200 rounded-lg dark:bg-red-500/10 dark:border-red-500/30">
                        <div class="flex items-start gap-3">
                            <svg class="shrink-0 size-5 text-red-600 dark:text-red-400 mt-0.5"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <circle cx="12" cy="12" r="10" />
                                <path d="M12 8v4" />
                                <path d="M12 16h.01" />
                            </svg>
                            <div>
                                <h4 class="font-semibold text-red-800 dark:text-red-300 text-sm">Perhatian!</h4>
                                <p class="text-sm text-red-700 dark:text-red-200 mt-1">
                                    Anda akan membatalkan Work Order ini. Tindakan ini tidak dapat dibatalkan. Pastikan
                                    Anda yakin sebelum melanjutkan.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Work Order Info -->
                    <div class="bg-gray-50 dark:bg-neutral-800 rounded-lg p-4 space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600 dark:text-neutral-400">Ref ID:</span>
                            <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200"
                                id="cancel-ref-id">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600 dark:text-neutral-400">Customer:</span>
                            <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200"
                                id="cancel-customer">-</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-gray-600 dark:text-neutral-400">Status:</span>
                            <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200"
                                id="cancel-status">-</span>
                        </div>
                    </div>

                    <!-- Password Input -->
                    <form id="cancel-confirmation-form">
                        <input type="hidden" id="cancel-order-id" name="order_id" value="">
                        <div>
                            <label for="cancel-password"
                                class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">
                                Masukkan Password Anda
                            </label>
                            <div class="relative">
                                <input type="password" id="cancel-password" name="password"
                                    class="py-2 px-3 block w-full border border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Masukkan password Anda" required>
                                <button type="button"
                                    class="toggle-password-btn absolute end-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-gray-700 dark:text-neutral-400 dark:hover:text-neutral-200 transition-colors"
                                    data-toggle="cancel-password">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">
                                Verifikasi password untuk keamanan
                            </p>
                        </div>

                        <!-- Error Message -->
                        <div id="cancel-error-message"
                            class="hidden mt-3 p-3 bg-red-50 border border-red-200 rounded-lg dark:bg-red-500/10 dark:border-red-500/30">
                            <p class="text-sm text-red-600 dark:text-red-400" id="error-text"></p>
                        </div>

                        <!-- Loading State -->
                        <div id="cancel-loading"
                            class="hidden mt-3 flex items-center gap-2 text-sm text-gray-600 dark:text-neutral-400">
                            <svg class="animate-spin shrink-0 size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M21.5 2v6h-6M2.5 22v-6h6M2 11.5a10 10 0 0 1 18.8-4.3M22 12.5a10 10 0 0 1-18.8 4.2" />
                            </svg>
                            <span>Memverifikasi password...</span>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center gap-x-3 px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                    <button type="button"
                        class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-200 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 transition-colors"
                        data-hs-overlay="#hs-cancel-confirmation-modal">
                        Batal
                    </button>
                    <button type="button" id="cancel-confirmation-submit"
                        class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none transition-colors">
                        Ya, Batalkan Work Order
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('hs-cancel-confirmation-modal');
    const passwordInput = document.getElementById('cancel-password');
    const submitBtn = document.getElementById('cancel-confirmation-submit');
    const errorMessage = document.getElementById('cancel-error-message');
    const errorText = document.getElementById('error-text');
    const loadingDiv = document.getElementById('cancel-loading');
    const togglePasswordBtns = document.querySelectorAll('.toggle-password-btn');

    // Toggle password visibility
    togglePasswordBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const inputId = this.getAttribute('data-toggle');
            const input = document.getElementById(inputId);
            if (input.type === 'password') {
                input.type = 'text';
                this.innerHTML = `
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                    </svg>
                `;
            } else {
                input.type = 'password';
                this.innerHTML = `
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>
                `;
            }
        });
    });

    // Handle form submission
    submitBtn.addEventListener('click', async function() {
        const password = passwordInput.value.trim();

        if (!password) {
            showError('Password tidak boleh kosong');
            return;
        }

        // Disable button and show loading
        submitBtn.disabled = true;
        loadingDiv.classList.remove('hidden');
        errorMessage.classList.add('hidden');

        try {
            const orderId = document.getElementById('cancel-order-id').value;
            const response = await fetch(`/production/work-orders/${orderId}/cancel `, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    password: password,
                    reason: 'Dibatalkan oleh user melalui dashboard'
                })
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Network response was not ok');
            }

            if (data.success) {
                // Close modal
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.close(modal);
                } else {
                    modal.classList.add('hidden');
                }
                
                // Show success message
                showSuccessNotification('Work Order berhasil dibatalkan');
                
                // Reload page after delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                showError(data.message || 'Gagal membatalkan Work Order');
            }
        } catch (error) {
            console.error('Error:', error);
            showError(error.message || 'Terjadi kesalahan saat memproses permintaan');
        } finally {
            submitBtn.disabled = false;
            loadingDiv.classList.add('hidden');
        }
    });

    function showError(message) {
        errorText.textContent = message;
        errorMessage.classList.remove('hidden');
        // Scroll to error message
        errorMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function showSuccessNotification(message) {
        // Create and show toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed top-4 end-4 z-[9999] bg-green-50 border border-green-200 text-sm text-green-800 rounded-lg p-4 dark:bg-green-500/10 dark:border-green-500/30 dark:text-green-400 shadow-lg';
        toast.innerHTML = `
            <div class="flex items-center gap-3">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                <span class="font-medium">${message}</span>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('opacity-0', 'transition-opacity', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Tambahkan event listener untuk membuka modal cancelled
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.status-update-btn')) {
            const button = e.target.closest('.status-update-btn');
            const status = button.getAttribute('data-status');
            
            // Jika status cancelled, buka modal
            if (status === 'cancelled') {
                e.preventDefault();
                
                const orderId = button.getAttribute('data-order-id');
                const row = button.closest('tr');
                
                // Ambil data dari row
                let refId = '-';
                let customer = '-';
                let currentStatus = '-';
                
                if (row) {
                    const refIdElement = row.querySelector('[data-ref-id]');
                    const customerElement = row.querySelector('[data-customer]');
                    const statusElement = row.querySelector('[data-status]');
                    
                    refId = refIdElement ? refIdElement.textContent.trim() : refIdElement.getAttribute('data-ref-id') || '-';
                    customer = customerElement ? customerElement.textContent.trim() : customerElement.getAttribute('data-customer') || '-';
                    currentStatus = statusElement ? statusElement.textContent.trim() : statusElement.getAttribute('data-status') || '-';
                }
                
                // Set data ke modal
                document.getElementById('cancel-order-id').value = orderId;
                document.getElementById('cancel-ref-id').textContent = refId;
                document.getElementById('cancel-customer').textContent = customer;
                document.getElementById('cancel-status').textContent = currentStatus;
                
                // Reset form
                document.getElementById('cancel-password').value = '';
                document.getElementById('cancel-password').type = 'password';
                document.getElementById('cancel-error-message').classList.add('hidden');
                
                // Reset toggle icon
                const toggleBtn = document.querySelector('[data-toggle="cancel-password"]');
                if (toggleBtn) {
                    toggleBtn.innerHTML = `
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                            <circle cx="12" cy="12" r="3"/>
                        </svg>
                    `;
                }
                
                // Open modal
                if (typeof HSOverlay !== 'undefined') {
                    HSOverlay.open(modal);
                } else {
                    modal.classList.remove('hidden');
                    document.body.style.overflow = 'hidden';
                }
                
                // Focus ke password input
                setTimeout(() => {
                    document.getElementById('cancel-password').focus();
                }, 100);
                
                return false;
            }
        }
    });
});
</script>
