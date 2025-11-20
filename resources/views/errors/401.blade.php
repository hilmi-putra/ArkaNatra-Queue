<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>401 Unauthorized - Akses Ditolak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes pulse-border {
            0%, 100% { border-color: rgb(239 68 68); }
            50% { border-color: rgb(252 165 165); }
        }
        .pulse-border {
            animation: pulse-border 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-red-50 to-pink-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Error Code -->
                <div class="md:w-1/2 bg-gradient-to-br from-red-500 to-pink-600 p-12 flex flex-col items-center justify-center text-white">
                    <div class="float-animation">
                        <div class="w-32 h-32 border-8 border-white/30 rounded-full flex items-center justify-center mb-6 pulse-border">
                            <i class="fas fa-lock text-6xl"></i>
                        </div>
                    </div>
                    <h1 class="text-8xl font-black mb-2">401</h1>
                    <p class="text-xl font-semibold opacity-90">Unauthorized</p>
                </div>
                
                <!-- Right Side - Content -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Akses Ditolak</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini. Silakan login dengan kredensial yang valid untuk melanjutkan.
                        </p>
                        
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-red-800">Apa yang bisa Anda lakukan?</p>
                                    <ul class="text-sm text-red-700 mt-1 list-disc list-inside">
                                        <li>Periksa kembali username dan password Anda</li>
                                        <li>Pastikan Anda sudah login dengan akun yang benar</li>
                                        <li>Hubungi administrator jika masalah berlanjut</li>
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
                        <a href="/login" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Login
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