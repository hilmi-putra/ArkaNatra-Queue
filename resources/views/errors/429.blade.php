<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>429 Too Many Requests - Terlalu Banyak Permintaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes rotate-slow {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .rotate-slow {
            animation: rotate-slow 20s linear infinite;
        }
        @keyframes pulse-red {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        .pulse-red {
            animation: pulse-red 1.5s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Error Code -->
                <div class="md:w-1/2 bg-gradient-to-br from-red-500 to-pink-600 p-12 flex flex-col items-center justify-center text-white">
                    <div class="mb-6 relative">
                        <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-hourglass-half text-6xl pulse-red"></i>
                        </div>
                        <div class="absolute inset-0 rotate-slow">
                            <i class="fas fa-clock text-3xl opacity-20"></i>
                        </div>
                    </div>
                    <h1 class="text-8xl font-black mb-2">429</h1>
                    <p class="text-xl font-semibold opacity-90">Too Many Requests</p>
                </div>
                
                <!-- Right Side - Content -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Terlalu Banyak Permintaan</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Anda telah mengirim terlalu banyak permintaan dalam waktu singkat. Untuk melindungi sistem, kami sementara membatasi akses Anda.
                        </p>
                        
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-red-800">Informasi Penting:</p>
                                    <ul class="text-sm text-red-700 mt-1 list-disc list-inside">
                                        <li>Tunggu beberapa menit sebelum mencoba lagi</li>
                                        <li>Hindari refresh berlebihan</li>
                                        <li>Periksa koneksi internet Anda</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/" class="flex-1 bg-gradient-to-r from-red-500 to-pink-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-red-600 hover:to-pink-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-home mr-2"></i>
                            Go to Homepage
                        </a>
                        <div class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold flex items-center justify-center">
                            <i class="fas fa-clock mr-2"></i>
                            <span id="countdown">Try again in 60s</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} SIMPKL. All rights reserved.</p>
        </div>
    </div>

    <script>
        // Countdown timer
        let timeLeft = 60;
        const countdownElement = document.getElementById('countdown');
        
        const countdown = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = `Try again in ${timeLeft}s`;
            
            if (timeLeft <= 0) {
                clearInterval(countdown);
                countdownElement.textContent = "Try again now";
                countdownElement.parentElement.classList.remove('bg-gray-100', 'text-gray-700');
                countdownElement.parentElement.classList.add('bg-green-100', 'text-green-700');
                countdownElement.parentElement.onclick = () => location.reload();
                countdownElement.parentElement.style.cursor = 'pointer';
            }
        }, 1000);
    </script>
</body>
</html>