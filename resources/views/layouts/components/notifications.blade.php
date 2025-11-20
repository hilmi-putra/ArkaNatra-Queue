@if (session('success') || session('error') || session('warning') || session('info'))
    @php
        $type = session('success') ? 'success' : (session('error') ? 'error' : (session('warning') ? 'warning' : 'info'));
        $message = session($type);

        $colors = [
            'success' => 'green',
            'error' => 'red', 
            'warning' => 'yellow',
            'info' => 'blue',
        ];
        $titles = [
            'success' => 'Success!',
            'error' => 'Error!',
            'warning' => 'Warning!',
            'info' => 'Information!',
        ];
        $color = $colors[$type];
        $title = $titles[$type];
        
        // Icon untuk setiap type
        $icons = [
            'success' => '<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>',
            'error' => '<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>',
            'warning' => '<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>',
            'info' => '<svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg>'
        ];
        $icon = $icons[$type];
    @endphp

    <!-- Toast Container - PERBAIKAN: z-index lebih tinggi dan posisi yang tepat -->
    <div 
        id="toast-container"
        class="fixed top-20 right-5 z-[10000] flex flex-col items-end space-y-3"
    >
        <!-- Toast Notification -->
        <div
            id="toast-notification"
            class="pointer-events-auto opacity-0 translate-x-20 transition-all duration-500 ease-out
                   bg-white border border-gray-200 shadow-2xl rounded-lg dark:bg-neutral-900 dark:border-neutral-800
                   w-full max-w-sm overflow-hidden"
        >
            <div class="flex items-start gap-3 p-4">
                <!-- Icon -->
                <span class="shrink-0 inline-flex justify-center items-center size-9 rounded-full border-4 
                    @if($color === 'green') border-green-50 bg-green-100 text-green-500 dark:bg-green-700 dark:border-green-600 dark:text-green-100
                    @elseif($color === 'red') border-red-50 bg-red-100 text-red-500 dark:bg-red-700 dark:border-red-600 dark:text-red-100
                    @elseif($color === 'yellow') border-yellow-50 bg-yellow-100 text-yellow-500 dark:bg-yellow-700 dark:border-yellow-600 dark:text-yellow-100
                    @else border-blue-50 bg-blue-100 text-blue-500 dark:bg-blue-700 dark:border-blue-600 dark:text-blue-100
                    @endif">
                    {!! $icon !!}
                </span>

                <!-- Text -->
                <div class="flex-1 min-w-0">
                    <h3 class="text-sm font-semibold text-gray-800 dark:text-neutral-200 truncate">{{ $title }}</h3>
                    <p class="text-sm text-gray-600 dark:text-neutral-400 mt-1 break-words">{{ $message }}</p>
                </div>

                <!-- Close Button -->
                <button type="button" 
                    class="close-toast shrink-0 size-6 inline-flex justify-center items-center gap-x-2 rounded-full border border-transparent bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-700 dark:hover:bg-neutral-600 dark:text-neutral-400 dark:focus:bg-neutral-600"
                    aria-label="Close">
                    <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                    </svg>
                </button>
            </div>

            <!-- Progress bar -->
            <div class="relative w-full h-1 bg-gray-200 dark:bg-neutral-700">
                <div id="toast-progress" 
                    class="absolute left-0 top-0 h-1 
                    @if($color === 'green') bg-green-500
                    @elseif($color === 'red') bg-red-500
                    @elseif($color === 'yellow') bg-yellow-500
                    @else bg-blue-500
                    @endif w-0 transition-all duration-3000 ease-linear"></div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toast = document.getElementById('toast-notification');
            const progress = document.getElementById('toast-progress');
            const closeButtons = document.querySelectorAll('.close-toast');
            let autoCloseTimeout;
            let progressInterval;

            function closeToast() {
                if (!toast) return;
                
                // Animasi keluar
                toast.classList.remove('translate-x-0');
                toast.classList.add('translate-x-20', 'opacity-0');
                
                // Hapus element setelah animasi selesai
                setTimeout(() => {
                    const container = document.getElementById('toast-container');
                    if (container) {
                        container.remove();
                    }
                }, 500);

                // Clear timeout dan interval
                clearTimeout(autoCloseTimeout);
                clearInterval(progressInterval);
            }

            function startProgressAnimation() {
                if (!progress) return;
                
                let width = 0;
                const duration = 3000; // 3 detik
                const interval = 30; // update setiap 30ms
                const increment = (100 / duration) * interval;

                progressInterval = setInterval(() => {
                    width += increment;
                    if (progress) {
                        progress.style.width = width + '%';
                    }
                    
                    if (width >= 100) {
                        clearInterval(progressInterval);
                    }
                }, interval);
            }

            // Animasi muncul
            setTimeout(() => {
                if (!toast) return;
                
                toast.classList.remove('opacity-0', 'translate-x-20');
                toast.classList.add('opacity-100', 'translate-x-0');

                // Mulai progress bar
                startProgressAnimation();

                // Auto close setelah 3 detik
                autoCloseTimeout = setTimeout(closeToast, 3000);
            }, 100);

            // Event listener untuk tombol close
            closeButtons.forEach(button => {
                button.addEventListener('click', closeToast);
            });

            // Juga close ketika klik di area toast (opsional)
            if (toast) {
                toast.addEventListener('click', function(e) {
                    if (e.target === this) {
                        closeToast();
                    }
                });
            }
        });
    </script>
@endif