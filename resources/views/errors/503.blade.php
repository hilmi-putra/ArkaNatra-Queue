<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 Service Unavailable - Layanan Tidak Tersedia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/preline/dist/preline.css">
    <script src="https://unpkg.com/preline/dist/preline.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @keyframes wrench {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(15deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(-15deg); }
            100% { transform: rotate(0deg); }
        }
        .wrench-animation {
            animation: wrench 2s ease-in-out infinite;
            transform-origin: center;
        }
        @keyframes pulse-blue {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
        }
        .pulse-blue {
            animation: pulse-blue 2s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-indigo-50 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="md:flex">
                <!-- Left Side - Error Code -->
                <div class="md:w-1/2 bg-gradient-to-br from-blue-500 to-indigo-600 p-12 flex flex-col items-center justify-center text-white">
                    <div class="mb-6">
                        <div class="w-32 h-32 bg-white/20 rounded-full flex items-center justify-center pulse-blue">
                            <i class="fas fa-wrench text-6xl wrench-animation"></i>
                        </div>
                    </div>
                    <h1 class="text-8xl font-black mb-2">503</h1>
                    <p class="text-xl font-semibold opacity-90">Service Unavailable</p>
                </div>
                
                <!-- Right Side - Content -->
                <div class="md:w-1/2 p-12">
                    <div class="mb-8">
                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Layanan Dalam Pemeliharaan</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Kami sedang melakukan pemeliharaan sistem untuk meningkatkan layanan. Layanan akan kembali tersedia dalam waktu dekat.
                        </p>
                        
                        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-3"></i>
                                <div>
                                    <p class="text-sm font-medium text-blue-800">Informasi Pemeliharaan:</p>
                                    <ul class="text-sm text-blue-700 mt-1 list-disc list-inside">
                                        <li>Pemeliharaan terjadwal: <span id="maintenance-time">--:--</span></li>
                                        <li>Perkiraan selesai: <span id="estimated-time">--:--</span></li>
                                        <li>Kami mohon maaf atas ketidaknyamanannya</li>
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
                        <button onclick="location.reload()" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transform hover:scale-105 transition-all duration-200 flex items-center justify-center">
                            <i class="fas fa-redo mr-2"></i>
                            Retry
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

    <script>
        // Set maintenance times (you can customize these)
        const now = new Date();
        const maintenanceStart = new Date(now.getTime() - 30 * 60000); // 30 minutes ago
        const maintenanceEnd = new Date(now.getTime() + 30 * 60000); // 30 minutes from now
        
        document.getElementById('maintenance-time').textContent = maintenanceStart.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
        document.getElementById('estimated-time').textContent = maintenanceEnd.toLocaleTimeString('id-ID', { 
            hour: '2-digit', 
            minute: '2-digit' 
        });
    </script>
</body>
</html>