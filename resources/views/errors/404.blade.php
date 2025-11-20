<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - Halaman Tidak Ditemukan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-30px); }
        }
        .bounce-animation {
            animation: bounce 2s ease-in-out infinite;
        }
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .rotate-animation {
            animation: rotate 20s linear infinite;
        }
        .star {
            position: absolute;
            opacity: 0;
            animation: twinkle 3s ease-in-out infinite;
        }
        @keyframes twinkle {
            0%, 100% { opacity: 0; transform: scale(0.5); }
            50% { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Error Code -->
                <div class="md:w-1/2 bg-gradient-to-br from-blue-500 to-indigo-600 p-12 flex flex-col items-center justify-center text-white relative overflow-hidden">
                    <!-- Stars decoration -->
                    <i class="fas fa-star star text-yellow-300 text-xl" style="top: 20%; left: 10%; animation-delay: 0s;"></i>
                    <i class="fas fa-star star text-yellow-300 text-sm" style="top: 30%; right: 15%; animation-delay: 1s;"></i>
                    <i class="fas fa-star star text-yellow-300 text-lg" style="bottom: 25%; left: 20%; animation-delay: 2s;"></i>
                    
                    <div class="bounce-animation mb-6">
                        <div class="w-32 h-32 relative">
                            <div class="absolute inset-0 rotate-animation">
                                <i class="fas fa-satellite-dish text-6xl opacity-50"></i>
                            </div>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <i class="fas fa-question-circle text-6xl"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="text-8xl font-black mb-2">404</h1>
                    <p class="text-xl font-semibold opacity-90">Not Found</p>
                </div>
                
                <!-- Right Side - Content -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Halaman Tidak Ditemukan</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Sepertinya Anda tersesat di ruang angkasa digital. Halaman yang Anda cari tidak dapat ditemukan atau telah dipindahkan.
                        </p>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-compass text-blue-500 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Saran Navigasi</p>
                                    <ul class="text-sm text-blue-700 mt-1 list-disc list-inside">
                                        <li>Periksa kembali URL yang Anda ketik</li>
                                        <li>Kunjungi halaman utama kami</li>
                                        <li>Gunakan fitur pencarian untuk menemukan konten</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/" class="flex-1 bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-blue-600 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-home mr-2"></i>
                            Go to Homepage
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} Your Company. All rights reserved.</p>
        </div>
    </div>
</body>
</html>