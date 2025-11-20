<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 Internal Server Error - Kesalahan Server</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes glitch {
            0%, 100% { transform: translate(0); }
            20% { transform: translate(-2px, 2px); }
            40% { transform: translate(-2px, -2px); }
            60% { transform: translate(2px, 2px); }
            80% { transform: translate(2px, -2px); }
        }
        .glitch-animation {
            animation: glitch 2s infinite;
        }
        @keyframes flicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .flicker-animation {
            animation: flicker 3s infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Error Code -->
                <div class="md:w-1/2 bg-gradient-to-br from-gray-800 to-gray-900 p-12 flex flex-col items-center justify-center text-white">
                    <div class="mb-6 glitch-animation">
                        <div class="w-32 h-32 bg-white/10 rounded-full flex items-center justify-center flicker-animation">
                            <i class="fas fa-server text-6xl"></i>
                        </div>
                    </div>
                    <h1 class="text-8xl font-black mb-2">500</h1>
                    <p class="text-xl font-semibold opacity-90">Internal Server Error</p>
                </div>
                
                <!-- Right Side - Content -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Kesalahan Server</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Maaf, terjadi kesalahan pada server kami. Tim teknis telah diberitahu dan sedang bekerja untuk memperbaiki masalah ini.
                        </p>
                        
                        <div class="bg-gray-50 border-l-4 border-gray-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-tools text-gray-500 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Yang sedang kami lakukan:</p>
                                    <ul class="text-sm text-gray-700 mt-1 list-disc list-inside">
                                        <li>Menganalisis log error</li>
                                        <li>Memperbaiki masalah teknis</li>
                                        <li>Memastikan sistem kembali normal</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="/" class="flex-1 bg-gradient-to-r from-gray-800 to-gray-900 text-white px-6 py-3 rounded-lg font-semibold hover:from-gray-900 hover:to-black transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl flex items-center justify-center">
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
        <div class="text-center mt-8 text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} SIMPKL. All rights reserved.</p>
        </div>
    </div>
</body>
</html>