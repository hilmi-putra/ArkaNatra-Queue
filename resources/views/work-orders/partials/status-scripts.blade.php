<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Status update functionality (untuk status selain cancelled)
        document.body.addEventListener('click', function(e) {
            if (e.target.closest('.status-update-btn')) {
                const button = e.target.closest('.status-update-btn');
                const newStatus = button.getAttribute('data-status');

                // Jika cancelled, biarkan modal handler yang menangani
                if (newStatus === 'cancelled') {
                    return;
                }

                e.preventDefault();
                const orderId = button.getAttribute('data-order-id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute(
                    'content');

                const statusNames = {
                    'validate': 'Validate',
                    'queue': 'Queue',
                    'pending': 'Pending',
                    'progress': 'Progress',
                    'revision': 'Revision',
                    'migration': 'Migration',
                    'finish': 'Finish',
                    'cancelled': 'Cancelled'
                };

                const statusName = statusNames[newStatus] || newStatus;

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
                            return response.json().then(data => {
                                throw new Error(data.message ||
                                    'Network response was not ok');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
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
                            throw new Error(data.message || 'Unknown error occurred');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed!',
                            text: error.message || 'An unexpected error occurred.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        });
                    });
            }
        });

        // Copy customer info functionality - robust and uses dataset
        function copyTextFallback(text) {
            return new Promise(function(resolve, reject) {
                try {
                    const textarea = document.createElement('textarea');
                    textarea.value = text;
                    textarea.setAttribute('readonly', '');
                    textarea.style.position = 'absolute';
                    textarea.style.left = '-9999px';
                    document.body.appendChild(textarea);
                    textarea.select();
                    const successful = document.execCommand('copy');
                    document.body.removeChild(textarea);
                    if (successful) resolve();
                    else reject(new Error('execCommand returned false'));
                } catch (err) {
                    reject(err);
                }
            });
        }

        document.querySelectorAll('.copy-customer-info-btn').forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const el = this;
                const refId = (el.dataset.refId || '').trim();
                const token = (el.dataset.token || '').trim();
                const customerName = (el.dataset.customerName || '').trim();
                const customerEmail = (el.dataset.customerEmail || '').trim();
                const baseUrl = (el.dataset.url || '').trim();

                // Debug logging - helps verify values present in DOM
                console.log('=== DEBUG COPY INFO ===');
                console.log('Ref ID:', refId);
                console.log('Token:', token);
                console.log('Customer Name:', customerName);
                console.log('Customer Email:', customerEmail);
                console.log('Base URL:', baseUrl);
                console.log('========================');

                let message = '';

                if (token) {
                    message =
                        `Untuk melihat status antrian pekerjaan Anda, silakan kunjungi website kami di ${baseUrl} dan gunakan informasi berikut:\n\nRef ID: ${refId}\nToken: ${token}\n\nTerima kasih.`;
                } else {
                    message =
                        `Informasi Work Order:\n\nRef ID: ${refId}\nCustomer: ${customerName || 'N/A'}${customerEmail ? '\nEmail: ' + customerEmail : ''}\n\nStatus: Token tidak tersedia, silakan hubungi administrator untuk informasi lebih lanjut.`;
                }

                const doCopy = (navigator.clipboard && navigator.clipboard.writeText) ?
                    navigator.clipboard.writeText(message) : copyTextFallback(message);

                doCopy.then(function() {
                    const originalHtml = button.innerHTML;
                    button.innerHTML =
                        `\n                <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">\n                    <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>\n                </svg>\n                Disalin!\n            `;

                    // Visual feedback
                    button.classList.remove('text-green-600', 'hover:bg-green-100');
                    button.classList.add('text-blue-600', 'bg-blue-50');

                    setTimeout(() => {
                        button.innerHTML = originalHtml;
                        button.classList.remove('text-blue-600', 'bg-blue-50');
                        button.classList.add('text-green-600',
                            'hover:bg-green-100');
                    }, 2000);
                }).catch(function(err) {
                    console.error('Gagal menyalin teks: ', err);
                    alert('Gagal menyalin teks ke clipboard');
                });
            });
        });
    });
</script>
