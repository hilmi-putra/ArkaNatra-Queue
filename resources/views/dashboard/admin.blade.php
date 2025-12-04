<!-- Admin Dashboard with Preline CSS Cards - Modern Design -->

<!-- Key Metrics Cards - 5 Column Layout -->
<div class="grid sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6 mb-6">
    <!-- Total Users Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">Total
                        Users</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800 dark:text-neutral-200">
                        {{ $metrics['total_users'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <svg class="size-6 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Customers Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">Total
                        Customers</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800 dark:text-neutral-200">
                        {{ $metrics['total_customers'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-emerald-50 dark:bg-emerald-900/30">
                        <svg class="size-6 text-emerald-600 dark:text-emerald-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="8.5" cy="7" r="4" />
                            <path d="M18 8c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3Z" />
                            <path d="M22 21v-1a4 4 0 0 0-3-3.87" />
                            <path d="M15 11.13a4 4 0 0 1 0 7.75" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">Total
                        Pengerjaan</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800 dark:text-neutral-200">
                        {{ $metrics['total_work_orders'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                        <svg class="size-6 text-purple-600 dark:text-purple-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                            <polyline points="14 2 14 8 20 8" />
                            <line x1="16" x2="8" y1="13" y2="13" />
                            <line x1="16" x2="8" y1="17" y2="17" />
                            <line x1="10" x2="8" y1="9" y2="9" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Finish Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">Selesai
                    </p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-500">
                        {{ $metrics['total_finish'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-green-50 dark:bg-green-900/30">
                        <svg class="size-6 text-green-600 dark:text-green-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Progress Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">Sedang
                        Dikerjakan</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-cyan-600 dark:text-cyan-500">
                        {{ $metrics['total_progress'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-cyan-50 dark:bg-cyan-900/30">
                        <svg class="size-6 text-cyan-600 dark:text-cyan-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2v4" />
                            <path d="m16.2 7.8 2.9-2.9" />
                            <path d="M18 12h4" />
                            <path d="m16.2 16.2 2.9 2.9" />
                            <path d="M12 18v4" />
                            <path d="m4.9 19.1 2.9-2.9" />
                            <path d="M2 12h4" />
                            <path d="m4.9 4.9 2.9 2.9" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Breakdown Row - 8 Status Cards -->
<div class="grid sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 sm:gap-4 mb-6">
    <!-- Queue Status Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-3 md:p-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Antrian</p>
                    <p class="mt-1 text-lg sm:text-2xl font-bold text-yellow-600 dark:text-yellow-500">
                        {{ $metrics['total_queue'] ?? 0 }}</p>
                </div>
                <span
                    class="inline-flex items-center justify-center h-9 w-9 rounded-lg bg-yellow-50 dark:bg-yellow-900/30">
                    <svg class="size-5 text-yellow-600 dark:text-yellow-500" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2" />
                        <line x1="3" x2="21" y1="9" y2="9" />
                        <line x1="9" x2="9" y1="21" y2="9" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <!-- Pending Status Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-3 md:p-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Tertunda</p>
                    <p class="mt-1 text-lg sm:text-2xl font-bold text-orange-600 dark:text-orange-500">
                        {{ $metrics['total_pending'] ?? 0 }}</p>
                </div>
                <span
                    class="inline-flex items-center justify-center h-9 w-9 rounded-lg bg-orange-50 dark:bg-orange-900/30">
                    <svg class="size-5 text-orange-600 dark:text-orange-500" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10" />
                        <polyline points="12 6 12 12 16 14" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <!-- Revision Status Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-3 md:p-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">Revisi
                    </p>
                    <p class="mt-1 text-lg sm:text-2xl font-bold text-red-600 dark:text-red-500">
                        {{ $metrics['total_revision'] ?? 0 }}</p>
                </div>
                <span class="inline-flex items-center justify-center h-9 w-9 rounded-lg bg-red-50 dark:bg-red-900/30">
                    <svg class="size-5 text-red-600 dark:text-red-500" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <!-- Migration Status Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-3 md:p-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Migrasi</p>
                    <p class="mt-1 text-lg sm:text-2xl font-bold text-cyan-600 dark:text-cyan-500">
                        {{ $metrics['total_migration'] ?? 0 }}</p>
                </div>
                <span
                    class="inline-flex items-center justify-center h-9 w-9 rounded-lg bg-cyan-50 dark:bg-cyan-900/30">
                    <svg class="size-5 text-cyan-600 dark:text-cyan-500" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 2v6h-6" />
                        <path d="M3 12a9 9 0 0 1 15-6.7L21 8" />
                        <path d="M3 22v-6h6" />
                        <path d="M21 12a9 9 0 0 1-15 6.7L3 16" />
                    </svg>
                </span>
            </div>
        </div>
    </div>

    <!-- Validate Status Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-3 md:p-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Validasi</p>
                    <p class="mt-1 text-lg sm:text-2xl font-bold text-slate-600 dark:text-slate-400">
                        {{ $metrics['total_validate'] ?? 0 }}</p>
                </div>
                <span
                    class="inline-flex items-center justify-center h-9 w-9 rounded-lg bg-slate-50 dark:bg-slate-900/30">
                    <svg class="size-5 text-slate-600 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                        <polyline points="22 4 12 14.01 9 11.01" />
                    </svg>
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Longer Migration Notifications & Work Orders Chart -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Longest Migrations Alert -->
    <div
        class="lg:col-span-1 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="inline-block size-5 text-orange-600 dark:text-orange-500"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <line x1="12" x2="12" y1="9" y2="13" />
                    <line x1="12" x2="12.01" y1="17" y2="17" />
                </svg>
                Menunggu Migrasi Terlama
            </h2>
        </div>
        <div class="p-4 space-y-3 max-h-80 overflow-y-auto">
            @forelse($longestMigrations ?? [] as $migration)
                <!-- Migration Item -->
                <div
                    class="group flex flex-col bg-gray-50 border border-gray-200 rounded-lg hover:shadow-md transition dark:bg-neutral-900 dark:border-neutral-700 p-3">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-2 flex-1 min-w-0">
                            <svg class="shrink-0 size-4 text-orange-600 dark:text-orange-500 mt-0.5"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M21 2v6h-6" />
                                <path d="M3 12a9 9 0 0 1 15-6.7L21 8" />
                                <path d="M3 22v-6h6" />
                                <path d="M21 12a9 9 0 0 1-15 6.7L3 16" />
                            </svg>
                            <div class="min-w-0 flex-1">
                                <h3 class="font-semibold text-sm text-gray-800 dark:text-neutral-200 truncate">
                                    {{ $migration->customer?->name ?? 'Unknown Customer' }}
                                </h3>
                                <p class="text-xs text-gray-600 dark:text-neutral-400 truncate">
                                    {{ $migration->workType?->work_type ?? 'Unknown Type' }}
                                </p>
                            </div>
                        </div>
                        <span
                            class="inline-flex items-center px-2 py-1 text-xs font-bold rounded-full bg-orange-100 dark:bg-orange-900/40 text-orange-700 dark:text-orange-300 shrink-0 ml-2">
                            {{ $migration->migration_days ?? 0 }}d
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-xs">
                        <span
                            class="inline-flex items-center gap-x-1 font-medium 
                            @if ($migration->status === 'finish') text-green-600 dark:text-green-500
                            @elseif($migration->status === 'progress') text-blue-600 dark:text-blue-500
                            @elseif($migration->status === 'revision') text-red-600 dark:text-red-500
                            @elseif($migration->status === 'pending') text-yellow-600 dark:text-yellow-500
                            @elseif($migration->status === 'migration') text-cyan-600 dark:text-cyan-500
                            @else text-gray-600 dark:text-gray-400 @endif">
                            <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="4" rx="2" ry="2" />
                                <line x1="16" x2="16" y1="2" y2="6" />
                                <line x1="8" x2="8" y1="2" y2="6" />
                                <line x1="3" x2="21" y1="10" y2="10" />
                            </svg>
                            {{ ucfirst($migration->status) }}
                        </span>

                        <span class="text-gray-500 dark:text-neutral-500">
                            {{ $migration->date_migration ?? 'N/A' }}
                        </span>
                    </div>
                </div>
                <!-- End Migration Item -->
            @empty
                <!-- Empty State -->
                <div class="text-center py-6">
                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-600 mb-3"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M21 2v6h-6" />
                        <path d="M3 12a9 9 0 0 1 15-6.7L21 8" />
                        <path d="M3 22v-6h6" />
                        <path d="M21 12a9 9 0 0 1-15 6.7L3 16" />
                    </svg>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tidak ada migrasi terlama</p>
                    <p class="text-xs text-gray-400 dark:text-gray-500">Semua pekerjaan berjalan sesuai timeline</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Work Orders Trend Chart - Preline UI -->
    <div
        class="lg:col-span-2 p-4 md:p-5 min-h-96 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700 w-full">
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-2 mb-4">
            <div class="w-full">
                <h2 class="text-sm text-gray-500 dark:text-neutral-500 flex items-center gap-2">
                    <svg class="inline-block size-5 text-blue-600 dark:text-blue-500"
                        xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="3 3 7 3 7 7 3 7 3 3" />
                        <polyline points="14 3 18 3 18 7 14 7 14 3" />
                        <polyline points="14 10 18 10 18 14 14 14 14 10" />
                        <polyline points="3 14 7 14 7 18 3 18 3 14" />
                    </svg>
                    Tren Pengerjaan
                </h2>
                <p class="text-xl sm:text-2xl font-medium text-gray-800 dark:text-neutral-200 mt-2">
                    {{ array_sum($workOrdersChartData['data'] ?? [0]) }} Pekerjaan (30 Hari)
                </p>
            </div>
        </div>
        <!-- End Header -->
        <div class="flex-1 w-full overflow-hidden" id="hs-work-orders-chart"></div>
    </div>
</div>

<!-- High Priority Items & Team Performance -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Priority Items -->
    <div
        class="lg:col-span-2 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M5 2a1 1 0 011 1v1h1a1 1 0 010 2H6v1a1 1 0 01-2 0V6H3a1 1 0 010-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2H6v1a1 1 0 11-2 0v-1H3a1 1 0 110-2h1v-1a1 1 0 011-1zM14 2a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0V6h-1a1 1 0 110-2h1V3a1 1 0 011-1zm0 10a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Pekerjaan Prioritas Tinggi
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Customer</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Tipe Pekerjaan
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Status</th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Alasan Prioritas
                        </th>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">PIC</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse($priorityItems ?? [] as $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition">
                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $item->customer?->name ?? 'Unknown' }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                {{ $item->workType?->work_type ?? 'Unknown' }}
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if ($item->status === 'finish') bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-200
                                    @elseif($item->status === 'progress') bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-200
                                    @elseif($item->status === 'revision') bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-200
                                    @elseif($item->status === 'migration') bg-cyan-100 dark:bg-cyan-900/30 text-cyan-800 dark:text-cyan-200
                                    @elseif($item->status === 'pending') bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200
                                    @else bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400 text-xs">
                                {{ $item->priority_reason }}
                            </td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">
                                @if ($item->productionUser)
                                    <span class="text-xs font-medium">{{ $item->productionUser->name }}</span>
                                @elseif($item->salesUser)
                                    <span class="text-xs font-medium">{{ $item->salesUser->name }}</span>
                                @else
                                    <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada pekerjaan prioritas
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Status Distribution -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 dark:bg-neutral-800 dark:border-neutral-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
            <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z">
                </path>
            </svg>
            Distribusi Status
        </h2>
        <div class="space-y-3">
            @forelse($statusDistribution ?? [] as $status)
                <div class="space-y-1">
                    <div class="flex justify-between items-center mb-1">
                        <span
                            class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $status['status'] }}</span>
                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-400">{{ $status['count'] }}
                            ({{ $status['percentage'] }}%)
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-neutral-700 rounded-full h-2">
                        <div class="h-2 rounded-full transition-all duration-300
                            @if ($status['status'] === 'finish') bg-green-500
                            @elseif($status['status'] === 'progress') bg-blue-500
                            @elseif($status['status'] === 'revision') bg-red-500
                            @elseif($status['status'] === 'migration') bg-cyan-500
                            @elseif($status['status'] === 'pending') bg-orange-500
                            @elseif($status['status'] === 'queue') bg-yellow-500
                            @else bg-gray-400 @endif"
                            style="width: {{ $status['percentage'] }}%">
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400 py-4 text-sm">Tidak ada data</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Team Performance Monitoring -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <!-- Production Team Performance -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-8 0v2h8z">
                    </path>
                </svg>
                Performa Tim Production
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Nama</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Total</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Selesai</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Tingkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse($teamPerformance['production'] ?? [] as $member)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition">
                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $member->productionUser?->name ?? 'Unknown' }}
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">
                                {{ $member->total_works }}
                            </td>
                            <td class="px-4 py-3 text-center text-green-600 dark:text-green-400 font-semibold">
                                {{ $member->completed_works }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span
                                        class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $member->completion_rate }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data tim production
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Sales Team Performance -->
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v2h8v-2zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-2a4 4 0 00-8 0v2h8z">
                    </path>
                </svg>
                Performa Tim Sales
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-neutral-700">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-700 dark:text-gray-300">Nama</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Total</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Selesai</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-700 dark:text-gray-300">Tingkat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                    @forelse($teamPerformance['sales'] ?? [] as $member)
                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition">
                            <td class="px-4 py-3 text-gray-900 dark:text-gray-100 font-semibold">
                                {{ $member->salesUser?->name ?? 'Unknown' }}
                            </td>
                            <td class="px-4 py-3 text-center text-gray-600 dark:text-gray-400">
                                {{ $member->total_works }}
                            </td>
                            <td class="px-4 py-3 text-center text-green-600 dark:text-green-400 font-semibold">
                                {{ $member->completed_works }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <span
                                        class="font-semibold text-emerald-600 dark:text-emerald-400">{{ $member->completion_rate }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada data tim sales
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Recent Activities Timeline -->
<div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-4 border-b border-gray-200 dark:border-neutral-700">
        <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
            <svg class="w-5 h-5 text-teal-600 dark:text-teal-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v2a1 1 0 001 1h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 15.27 4.632 17 6.414 17H15a1 1 0 000-2H6.414l1-1H14a2 2 0 001.789-2.894l-1.789-5.573A1 1 0 0013 6H9V4a1 1 0 00-.553-.894l-1.003-.501a1 1 0 00-1.444.894v2H6V3a1 1 0 00-1-1zm6 16a2 2 0 11-4 0 2 2 0 014 0z"
                    clip-rule="evenodd"></path>
            </svg>
            Aktivitas Terbaru
        </h2>
    </div>
    <div class="p-4">
        <div class="space-y-4 max-h-96 overflow-y-auto">
            @forelse($recentActivities ?? [] as $activity)
                <div
                    class="flex gap-4 pb-4 border-b border-gray-200 dark:border-neutral-700 last:border-b-0 last:pb-0">
                    <div class="flex-shrink-0">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">
                            {{ $activity->activity_description }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            {{ $activity->time_ago }}
                        </p>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 dark:text-gray-400 py-8">Tidak ada aktivitas terbaru</p>
            @endforelse
        </div>
    </div>
</div>

@section('scripts')
    <!-- ApexCharts for Work Orders Trend with Preline UI -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/apexcharts/dist/apexcharts.css">
    <style type="text/css">
        .apexcharts-tooltip.apexcharts-theme-light {
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/lodash/lodash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline/dist/helper-apexcharts.js"></script>

    <script>
        window.addEventListener('load', () => {
            (function() {
                const chartData = @json($workOrdersChartData ?? []);

                buildChart(
                    '#hs-work-orders-chart',
                    (mode) => ({
                        chart: {
                            height: 300,
                            type: 'area',
                            toolbar: {
                                show: false,
                            },
                            zoom: {
                                enabled: false,
                            },
                        },
                        series: [{
                            name: 'Tren Pengerjaan',
                            data: chartData.data || [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0,
                                0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0
                            ],
                        }, ],
                        legend: {
                            show: false,
                        },
                        dataLabels: {
                            enabled: false,
                        },
                        stroke: {
                            curve: 'smooth',
                            width: 2,
                        },
                        grid: {
                            strokeDashArray: 2,
                        },
                        fill: {
                            type: 'gradient',
                            gradient: {
                                type: 'vertical',
                                shadeIntensity: 1,
                                opacityFrom: 0.1,
                                opacityTo: 0.8,
                            },
                        },
                        xaxis: {
                            type: 'category',
                            tickPlacement: 'on',
                            categories: chartData.labels || [],
                            axisBorder: {
                                show: false,
                            },
                            axisTicks: {
                                show: false,
                            },
                            crosshairs: {
                                stroke: {
                                    dashArray: 0,
                                },
                                dropShadow: {
                                    show: false,
                                },
                            },
                            tooltip: {
                                enabled: false,
                            },
                            labels: {
                                style: {
                                    colors: '#9ca3af',
                                    fontSize: '13px',
                                    fontFamily: 'Inter, ui-sans-serif',
                                    fontWeight: 400,
                                },
                                formatter: (title) => {
                                    let t = title;
                                    if (t && typeof t === 'string') {
                                        const parts = t.split(' ');
                                        if (parts.length >= 2) {
                                            t = `${parts[0]} ${parts[1].slice(0, 3)}`;
                                        }
                                    }
                                    return t;
                                },
                            },
                        },
                        yaxis: {
                            labels: {
                                align: 'left',
                                minWidth: 0,
                                maxWidth: 140,
                                style: {
                                    colors: '#9ca3af',
                                    fontSize: '13px',
                                    fontFamily: 'Inter, ui-sans-serif',
                                    fontWeight: 400,
                                },
                                formatter: (value) => (value >= 1000 ? `${value / 1000}k` : value),
                            },
                        },
                        tooltip: {
                            x: {
                                format: 'MMMM yyyy',
                            },
                            y: {
                                formatter: (value) => `${value >= 1000 ? `${value / 1000}k` : value}`,
                            },
                            custom: function(props) {
                                const {
                                    categories
                                } = props.ctx.opts.xaxis;
                                const {
                                    dataPointIndex
                                } = props;
                                const title = categories[dataPointIndex] ? categories[
                                    dataPointIndex].split(' ') : [];
                                const newTitle = title.length >= 2 ? `${title[0]} ${title[1]}` :
                                    categories[dataPointIndex];

                                return buildTooltip(props, {
                                    title: newTitle,
                                    mode,
                                    valuePrefix: '',
                                    hasTextLabel: true,
                                    wrapperExtClasses: 'min-w-28',
                                });
                            },
                        },
                        responsive: [{
                            breakpoint: 568,
                            options: {
                                chart: {
                                    height: 300,
                                },
                                labels: {
                                    style: {
                                        colors: '#9ca3af',
                                        fontSize: '11px',
                                        fontFamily: 'Inter, ui-sans-serif',
                                        fontWeight: 400,
                                    },
                                    offsetX: -2,
                                    formatter: (title) => title.slice(0, 3),
                                },
                                yaxis: {
                                    labels: {
                                        align: 'left',
                                        minWidth: 0,
                                        maxWidth: 140,
                                        style: {
                                            colors: '#9ca3af',
                                            fontSize: '11px',
                                            fontFamily: 'Inter, ui-sans-serif',
                                            fontWeight: 400,
                                        },
                                        formatter: (value) => value >= 1000 ?
                                            `${value / 1000}k` : value,
                                    },
                                },
                            },
                        }, ],
                    }), {
                        colors: ['#2563eb', '#9333ea'],
                        fill: {
                            gradient: {
                                stops: [0, 90, 100],
                            },
                        },
                        grid: {
                            borderColor: '#e5e7eb',
                        },
                    }, {
                        colors: ['#3b82f6', '#a855f7'],
                        fill: {
                            gradient: {
                                stops: [100, 90, 0],
                            },
                        },
                        grid: {
                            borderColor: '#404040',
                        },
                    }
                );
            })();
        });
    </script>
@endsection
