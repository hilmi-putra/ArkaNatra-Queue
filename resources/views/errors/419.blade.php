<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 CSRF Token Mismatch - Kesalahan Keamanan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(251, 146, 60, 0.5); }
            50% { box-shadow: 0 0 40px rgba(251, 146, 60, 0.8); }
        }
        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite;
        }
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .shake-animation {
            animation: shake 0.5s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 to-amber-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Error Code -->
                <div class="md:w-1/2 bg-gradient-to-br from-orange-500 to-amber-600 p-12 flex flex-col items-center justify-center text-white">
                    <div class="shake-animation mb-6">
                        <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center pulse-glow">
                            <i class="fas fa-shield-alt text-6xl"></i>
                        </div>
                    </div>
                    <h1 class="text-8xl font-black mb-2">419</h1>
                    <p class="text-xl font-semibold opacity-90">CSRF Token Mismatch</p>
                </div>
                
                <!-- Right Side - Content -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Kesalahan Keamanan</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Token keamanan (CSRF) tidak valid atau telah kedaluwarsa. Ini biasanya terjadi karena sesi Anda telah habis atau halaman telah terbuka terlalu lama.
                        </p>
                        
                        <div class="bg-orange-50 border-l-4 border-orange-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-orange-500 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-orange-800">Solusi yang disarankan:</p>
                                    <ul class="text-sm text-orange-700 mt-1 list-disc list-inside">
                                        <li>Refresh halaman ini</li>
                                        <li>Login kembali jika diminta</li>
                                        <li>Hindari membuka halaman terlalu lama</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/" class="flex-1 bg-gradient-to-r from-orange-500 to-amber-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-orange-600 hover:to-amber-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-home mr-2"></i>
                            Go to Homepage
                        </a>
                        <button onclick="location.reload()" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Refresh Page
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; {{ date('Y') }} SIMPKL. All rights reserved.</p>
        </div>
    </div>
</body>
</html>