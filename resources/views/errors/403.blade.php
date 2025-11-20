<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Forbidden - Akses Terlarang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }
        .shake-animation {
            animation: shake 0.5s ease-in-out infinite;
        }
        @keyframes glow {
            0%, 100% { box-shadow: 0 0 20px rgba(245, 158, 11, 0.5); }
            50% { box-shadow: 0 0 40px rgba(245, 158, 11, 0.8); }
        }
        .glow-animation {
            animation: glow 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-amber-50 to-orange-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Error Code -->
                <div class="md:w-1/2 bg-gradient-to-br from-amber-500 to-orange-600 p-12 flex flex-col items-center justify-center text-white">
                    <div class="shake-animation mb-6">
                        <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center glow-animation">
                            <i class="fas fa-ban text-6xl"></i>
                        </div>
                    </div>
                    <h1 class="text-8xl font-black mb-2">403</h1>
                    <p class="text-xl font-semibold opacity-90">Forbidden</p>
                </div>
                
                <!-- Right Side - Content -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Akses Terlarang</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Anda tidak memiliki hak akses yang cukup untuk melihat konten ini. Halaman ini hanya dapat diakses oleh pengguna dengan izin khusus.
                        </p>
                        
                        <div class="bg-amber-50 border-l-4 border-amber-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-shield-alt text-amber-500 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-amber-800">Informasi Penting</p>
                                    <ul class="text-sm text-amber-700 mt-1 list-disc list-inside">
                                        <li>Halaman ini memerlukan level akses administrator</li>
                                        <li>Periksa kembali izin akun Anda</li>
                                        <li>Minta bantuan dari administrator sistem</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/" class="flex-1 bg-gradient-to-r from-amber-500 to-orange-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-amber-600 hover:to-orange-700 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
                            <i class="fas fa-home mr-2"></i>
                            Go to Homepage
                        </a>
                        <button onclick="history.back()" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Go Back
                        </button>
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