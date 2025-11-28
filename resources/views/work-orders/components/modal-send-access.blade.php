<!-- Send Access Modal -->
<div id="hs-send-access-modal"
    class="hs-overlay hidden size-full fixed top-0 start-0 z-80 overflow-x-hidden overflow-y-auto" role="dialog"
    tabindex="-1" aria-labelledby="hs-delete-workorder-modal-label">
    <div
        class="hs-overlay-open:mt-7 hs-overlay-open:opacity-100 hs-overlay-open:duration-500
               mt-0 opacity-0 ease-out transition-all md:max-w-2xl md:w-full m-3 md:mx-auto">
        <div
            class="relative flex flex-col bg-white border border-gray-200 shadow-2xs rounded-xl overflow-hidden dark:bg-neutral-900 dark:border-neutral-800">

            <!-- Header -->
            <div class="flex justify-between items-center py-3 px-4 border-b border-gray-200 dark:border-neutral-800">
                <h3 id="hs-send-access-modal-label" class="font-bold text-gray-800 dark:text-white">
                    Kirim Akses Credentials
                </h3>
                <button type="button"
                    class="size-8 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                    aria-label="Close" data-hs-overlay="#hs-send-access-modal">
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
                    <label for="send-access-password" class="block text-sm font-medium mb-2 dark:text-white">
                        Verifikasi Password
                    </label>
                    <input type="password" id="send-access-password" name="password"
                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                        placeholder="Masukkan password Anda" required>
                    <div id="send-access-password-error" class="hidden text-xs text-red-600 mt-2"></div>
                </div>

                <!-- Credentials Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium mb-3 dark:text-white">
                        Pilih Credentials yang akan diaktifkan:
                    </label>
                    <div class="space-y-3">
                        <!-- Web Checkbox -->
                        <div class="flex">
                            <input type="checkbox" id="credential-web" name="credentials[]" value="web"
                                class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="credential-web" class="text-sm text-gray-600 ms-3 dark:text-neutral-400">
                                <span class="font-medium text-gray-800 dark:text-neutral-200">Website</span>
                                <p class="text-xs text-gray-500 dark:text-neutral-500 mt-0.5">Akses control panel
                                    website</p>
                            </label>
                        </div>

                        <!-- OJS Checkbox -->
                        <div class="flex">
                            <input type="checkbox" id="credential-ojs" name="credentials[]" value="ojs"
                                class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="credential-ojs" class="text-sm text-gray-600 ms-3 dark:text-neutral-400">
                                <span class="font-medium text-gray-800 dark:text-neutral-200">OJS</span>
                                <p class="text-xs text-gray-500 dark:text-neutral-500 mt-0.5">Akses Open Journal System
                                </p>
                            </label>
                        </div>

                        <!-- cPanel Checkbox -->
                        <div class="flex">
                            <input type="checkbox" id="credential-cpanel" name="credentials[]" value="cpanel"
                                class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="credential-cpanel" class="text-sm text-gray-600 ms-3 dark:text-neutral-400">
                                <span class="font-medium text-gray-800 dark:text-neutral-200">cPanel</span>
                                <p class="text-xs text-gray-500 dark:text-neutral-500 mt-0.5">Akses hosting control
                                    panel</p>
                            </label>
                        </div>

                        <!-- Webmail Checkbox -->
                        <div class="flex">
                            <input type="checkbox" id="credential-webmail" name="credentials[]" value="webmail"
                                class="shrink-0 mt-0.5 border-gray-300 rounded text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-600 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800">
                            <label for="credential-webmail" class="text-sm text-gray-600 ms-3 dark:text-neutral-400">
                                <span class="font-medium text-gray-800 dark:text-neutral-200">Webmail</span>
                                <p class="text-xs text-gray-500 dark:text-neutral-500 mt-0.5">Akses email web client</p>
                            </label>
                        </div>
                    </div>
                    <div id="send-access-credentials-error" class="hidden text-xs text-red-600 mt-2"></div>
                </div>

                <!-- Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 dark:bg-blue-900/20 dark:border-blue-800">
                    <div class="flex items-start gap-3">
                        <svg class="shrink-0 size-5 text-blue-600 dark:text-blue-500 mt-0.5"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M12 16v-4" />
                            <path d="M12 8h.01" />
                        </svg>
                        <div class="text-sm">
                            <span class="font-semibold text-blue-800 dark:text-blue-600">Informasi:</span>
                            <p class="text-blue-700 dark:text-blue-500 mt-1">
                                Credentials yang dipilih akan diaktifkan dan dapat dilihat oleh customer melalui halaman
                                queue dengan token mereka.
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
                    data-hs-overlay="#hs-send-access-modal">
                    Batal
                </button>
                <button type="button" id="send-access-submit"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="m22 2-7 20-4-9-9-4Z" />
                        <path d="M22 2 11 13" />
                    </svg>
                    Kirim Akses
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sendAccessModal = document.getElementById('hs-send-access-modal');
        const submitButton = document.getElementById('send-access-submit');
        const passwordInput = document.getElementById('send-access-password');
        const passwordError = document.getElementById('send-access-password-error');
        const credentialsError = document.getElementById('send-access-credentials-error');
        let workOrderId;
        let credentialData = {}; // Untuk menyimpan data credential

        // Add a click event listener to all buttons that can open this modal
        document.addEventListener('click', function(e) {
            const triggerElement = e.target.closest('[data-hs-overlay="#hs-send-access-modal"]');
            if (triggerElement && triggerElement.hasAttribute('data-workorder-id')) {
                workOrderId = triggerElement.getAttribute('data-workorder-id');
                
                // Ambil data credential dari atribut data (cek apakah ada isinya)
                credentialData = {
                    web: triggerElement.getAttribute('data-credential-web') !== null && 
                         triggerElement.getAttribute('data-credential-web') !== '' &&
                         triggerElement.getAttribute('data-credential-web') !== 'null',
                    ojs: triggerElement.getAttribute('data-credential-ojs') !== null && 
                         triggerElement.getAttribute('data-credential-ojs') !== '' &&
                         triggerElement.getAttribute('data-credential-ojs') !== 'null',
                    cpanel: triggerElement.getAttribute('data-credential-cpanel') !== null && 
                           triggerElement.getAttribute('data-credential-cpanel') !== '' &&
                           triggerElement.getAttribute('data-credential-cpanel') !== 'null',
                    webmail: triggerElement.getAttribute('data-credential-webmail') !== null && 
                            triggerElement.getAttribute('data-credential-webmail') !== '' &&
                            triggerElement.getAttribute('data-credential-webmail') !== 'null'
                };
                
                // Reset form dan update tampilan checkbox
                resetForm();
                updateCheckboxVisibility();
            }
        });

        // Fungsi untuk menyembunyikan/menampilkan checkbox berdasarkan data credential
        function updateCheckboxVisibility() {
            const checkboxes = {
                web: document.getElementById('credential-web'),
                ojs: document.getElementById('credential-ojs'),
                cpanel: document.getElementById('credential-cpanel'),
                webmail: document.getElementById('credential-webmail')
            };

            // Loop melalui semua credential dan sembunyikan yang tidak ada isinya
            Object.keys(checkboxes).forEach(credentialType => {
                const checkboxContainer = checkboxes[credentialType].closest('.flex');
                
                if (credentialData[credentialType]) {
                    // Tampilkan jika credential memiliki data/isinya
                    checkboxContainer.style.display = 'flex';
                } else {
                    // Sembunyikan jika credential null/tidak ada isinya
                    checkboxContainer.style.display = 'none';
                }
            });

            // Cek jika semua credential tidak ada isinya, tampilkan pesan
            const hasAvailableCredentials = Object.values(credentialData).some(value => value === true);
            if (!hasAvailableCredentials) {
                const credentialsSection = document.querySelector('.mb-6:has(.space-y-3)');
                credentialsSection.innerHTML = `
                    <div class="text-center py-4">
                        <svg class="mx-auto size-12 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                            <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                            <path d="M10 9H8"/>
                            <path d="M16 13H8"/>
                            <path d="M16 17H8"/>
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-neutral-400 mt-2">
                            Tidak ada credentials yang tersedia untuk work order ini.
                        </p>
                    </div>
                `;
            }
        }

        function resetForm() {
            passwordInput.value = '';
            passwordError.textContent = '';
            passwordError.classList.add('hidden');
            credentialsError.textContent = '';
            credentialsError.classList.add('hidden');
            
            // Uncheck all checkboxes
            document.querySelectorAll('#hs-send-access-modal input[name="credentials[]"]').forEach(checkbox => {
                checkbox.checked = false;
            });
            
            // Re-enable button
            submitButton.disabled = false;
            submitButton.innerHTML = `
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m22 2-7 20-4-9-9-4Z" />
                    <path d="M22 2 11 13" />
                </svg>
                Kirim Akses
            `;
        }

        submitButton.addEventListener('click', function() {
            // Reset errors
            passwordError.textContent = '';
            passwordError.classList.add('hidden');
            credentialsError.textContent = '';
            credentialsError.classList.add('hidden');

            const password = passwordInput.value;
            const credentials = Array.from(document.querySelectorAll(
                    '#hs-send-access-modal input[name="credentials[]"]:checked'))
                .map(checkbox => checkbox.value);

            // Validation
            let hasError = false;
            if (!password) {
                passwordError.textContent = 'Password wajib diisi.';
                passwordError.classList.remove('hidden');
                hasError = true;
            }

            // Cek apakah ada credential yang tersedia
            const hasAvailableCredentials = Object.values(credentialData).some(value => value === true);
            if (hasAvailableCredentials && credentials.length === 0) {
                credentialsError.textContent = 'Pilih minimal satu jenis credential.';
                credentialsError.classList.remove('hidden');
                hasError = true;
            }

            if (hasError) {
                return;
            }

            // Show loading SweetAlert
            Swal.fire({
                title: 'Mengirim Akses...',
                text: 'Sedang memproses pengiriman credentials',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            @php
                $role = auth()->user()->getRoleNames()->first();
                $routeName = $role . '.work-orders.send-access';
            @endphp

            const url = "{{ route($routeName, ['workOrder' => ':workOrderId']) }}".replace(
                ':workOrderId', workOrderId);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        password: password,
                        credentials: credentials
                    })
                })
                .then(response => {
                    // Parse response as JSON regardless of status
                    return response.json().then(data => {
                        return {
                            status: response.status,
                            ok: response.ok,
                            data: data
                        };
                    });
                })
                .then(({ status, ok, data }) => {
                    if (ok && data.success) {
                        // Success - show quick success then force reload
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message || 'Status updated successfully!',
                            showConfirmButton: false,
                            timer: 1000
                        });

                        // Force reload after very short delay
                        setTimeout(() => {
                            window.location.href = window.location.href; // Force reload
                        }, 1000);
                    } else {
                        throw {
                            status: status,
                            data: data
                        };
                    }
                })
                .catch(error => {
                    console.error('Fetch Error:', error);
                    
                    let errorMessage = 'Terjadi kesalahan yang tidak diketahui.';
                    
                    // Close loading alert first
                    Swal.close();
                    
                    // Handle different error cases
                    if (error.status === 422 && error.data && error.data.errors) {
                        // Validation errors
                        if (error.data.errors.password) {
                            passwordError.textContent = error.data.errors.password[0];
                            passwordError.classList.remove('hidden');
                        }
                        if (error.data.errors.credentials) {
                            credentialsError.textContent = error.data.errors.credentials[0];
                            credentialsError.classList.remove('hidden');
                        }
                        errorMessage = 'Terjadi kesalahan validasi.';
                    } else if (error.status === 401) {
                        // Wrong password
                        passwordError.textContent = error.data.message || 'Password salah!';
                        passwordError.classList.remove('hidden');
                        errorMessage = error.data.message || 'Password salah!';
                    } else if (error.status === 409) {
                        // Already sent
                        errorMessage = error.data.message || 'Akses sudah pernah dikirim.';
                    } else if (error.status === 404) {
                        // Not found
                        errorMessage = error.data.message || 'Data credentials tidak ditemukan.';
                    } else if (error.data && error.data.message) {
                        // Other server errors with message
                        errorMessage = error.data.message;
                    } else if (error.message && error.message !== 'Failed to fetch') {
                        // Network or other errors (excluding common fetch errors)
                        errorMessage = error.message;
                    }
                    
                    // Show error SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                });
        });

        // Close modal handler to reset form
        sendAccessModal.addEventListener('close', resetForm);
    });
</script>
