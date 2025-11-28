<!-- Sales Dashboard with Preline CSS Cards - Modern Design -->

<!-- Key Metrics Cards - 4 Column Layout -->
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
    <!-- Total Sales Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Terjual</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800 dark:text-neutral-200">
                        {{ $metrics['total_sales'] ?? 0 }}
                    </p>
                </div>
                <div class="shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-purple-50 dark:bg-purple-900/30">
                        <svg class="size-6 text-purple-600 dark:text-purple-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1" />
                            <circle cx="20" cy="21" r="1" />
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Finished Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Selesai</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-green-600 dark:text-green-500">
                        {{ $metrics['total_finish'] ?? 0 }}
                    </p>
                </div>
                <div class="shrink-0">
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

    <!-- In Progress Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Proses</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-cyan-600 dark:text-cyan-500">
                        {{ $metrics['total_progress'] ?? 0 }}
                    </p>
                </div>
                <div class="shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-cyan-50 dark:bg-cyan-900/30">
                        <svg class="size-6 text-cyan-600 dark:text-cyan-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10" />
                            <path d="M20.49 15a9 9 0 1 1 .12-10.53" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Menunggu</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-orange-600 dark:text-orange-500">
                        {{ $metrics['total_pending'] ?? 0 }}
                    </p>
                </div>
                <div class="shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-orange-50 dark:bg-orange-900/30">
                        <svg class="size-6 text-orange-600 dark:text-orange-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics & Status Breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Performance Metrics Card -->
    <div
        class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-indigo-600 dark:text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" x2="12" y1="2" y2="22" />
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                </svg>
                Performa
            </h2>
        </div>
        <div class="p-4 space-y-4">
            <div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat Selesai</span>
                    <span class="text-lg font-bold text-green-600 dark:text-green-500">
                        {{ $performanceMetrics['completion_rate'] ?? 0 }}%
                    </span>
                </div>
                <div class="h-2 bg-gray-200 dark:bg-neutral-700 rounded-full overflow-hidden">
                    <div class="h-full bg-green-600 dark:bg-green-500 rounded-full transition-all"
                        style="width: {{ $performanceMetrics['completion_rate'] ?? 0 }}%"></div>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Hari</span>
                    <span class="text-lg font-bold text-blue-600 dark:text-blue-500">
                        {{ $performanceMetrics['avg_completion_days'] ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Total Terjual</span>
                    <span class="text-lg font-bold text-purple-600 dark:text-purple-500">
                        {{ $performanceMetrics['total_sales'] ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Selesai Dijual</span>
                    <span class="text-lg font-bold text-emerald-600 dark:text-emerald-500">
                        {{ $performanceMetrics['total_completed'] ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Breakdown Chart -->
    <div
        class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-emerald-600 dark:text-emerald-500" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7" />
                    <rect x="14" y="3" width="7" height="7" />
                    <rect x="14" y="14" width="7" height="7" />
                    <rect x="3" y="14" width="7" height="7" />
                </svg>
                Distribusi Status
            </h2>
        </div>
        <div class="p-4 space-y-4">
            @forelse($statusBreakdown ?? [] as $item)
                @php
                    $dotColor = match($item['status']) {
                        'validate' => '#fbbf24',
                        'queue' => '#3b82f6',
                        'pending' => '#f97316',
                        'progress' => '#06b6d4',
                        'revision' => '#ef4444',
                        'migration' => '#8b5cf6',
                        'finish' => '#10b981',
                        default => '#6b7280'
                    };
                @endphp
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full" style="background-color: {{ $dotColor }}"></div>
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $item['label'] }}</span>
                    </div>
                    <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $item['count'] }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada data status</p>
            @endforelse
        </div>
    </div>

    <!-- Priority Items -->
    <div
        class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-red-600 dark:text-red-500" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <line x1="12" x2="12" y1="9" y2="13" />
                    <line x1="12" x2="12.01" y1="17" y2="17" />
                </svg>
                Perlu Perhatian
            </h2>
        </div>
        <div class="p-4 space-y-3 max-h-80 overflow-y-auto">
            @forelse($priorityItems ?? [] as $item)
                @php
                    $statusColors = [
                        'validate' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                        'queue' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                        'pending' => ['bg' => '#fed7aa', 'text' => '#9a3412'],
                        'progress' => ['bg' => '#cffafe', 'text' => '#0e7490'],
                        'revision' => ['bg' => '#fee2e2', 'text' => '#7f1d1d'],
                        'migration' => ['bg' => '#ede9fe', 'text' => '#5b21b6'],
                        'finish' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                    ];
                    $colors = $statusColors[$item->status] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                @endphp
                <div
                    class="flex items-center justify-between p-2 text-xs bg-red-50 dark:bg-red-900/20 rounded border border-red-200 dark:border-red-800/50">
                    <span class="text-gray-700 dark:text-gray-300 font-medium truncate">
                        {{ $item->priority_reason }}
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-bold whitespace-nowrap ml-2"
                        style="background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}">
                        {{ $item->status_display ?? ucfirst($item->status) }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada item prioritas</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Recent Sales Table -->
<div
    class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
    <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
        <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
            <svg class="size-5 text-indigo-600 dark:text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M13 2H3v20h18V8z" />
                <polyline points="13 2 13 8 19 8" />
            </svg>
            Penjualan Terbaru
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <thead class="bg-gray-50 dark:bg-neutral-700/50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Customer</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Jenis Pekerjaan</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Status</th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                @forelse($recentSales ?? [] as $sale)
                    @php
                        $statusColors = [
                            'validate' => ['bg' => '#fef3c7', 'text' => '#92400e'],
                            'queue' => ['bg' => '#dbeafe', 'text' => '#1e40af'],
                            'pending' => ['bg' => '#fed7aa', 'text' => '#9a3412'],
                            'progress' => ['bg' => '#cffafe', 'text' => '#0e7490'],
                            'revision' => ['bg' => '#fee2e2', 'text' => '#7f1d1d'],
                            'migration' => ['bg' => '#ede9fe', 'text' => '#5b21b6'],
                            'finish' => ['bg' => '#d1fae5', 'text' => '#065f46'],
                        ];
                        $colors = $statusColors[$sale->status] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $sale->customer?->name ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            {{ $sale->workType?->work_type ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold"
                                style="background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}">
                                {{ $sale->status_display ?? ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $sale->time_ago ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada penjualan terbaru
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>