<!-- Production Dashboard with Preline CSS Cards - Modern Design -->

<!-- Key Metrics Cards - 4 Column Layout -->
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
    <!-- Total Assigned Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Ditugaskan</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800 dark:text-neutral-200">
                        {{ $metrics['total_assigned'] ?? 0 }}
                    </p>
                </div>
                <div class="shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-indigo-50 dark:bg-indigo-900/30">
                        <svg class="size-6 text-indigo-600 dark:text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
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

    <!-- Queue Items Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Antrian</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-orange-600 dark:text-orange-500">
                        {{ $metrics['total_queue'] ?? 0 }}
                    </p>
                </div>
                <div class="shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-orange-50 dark:bg-orange-900/30">
                        <svg class="size-6 text-orange-600 dark:text-orange-500" xmlns="http://www.w3.org/2000/svg"
                            width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" x2="21" y1="6" y2="6" />
                            <line x1="8" x2="21" y1="12" y2="12" />
                            <line x1="8" x2="21" y1="18" y2="18" />
                            <line x1="3" x2="3.01" y1="6" y2="6" />
                            <line x1="3" x2="3.01" y1="12" y2="12" />
                            <line x1="3" x2="3.01" y1="18" y2="18" />
                        </svg>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Performance Metrics & Active Queue -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Performance Metrics Card -->
    <div
        class="flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-purple-600 dark:text-purple-500" xmlns="http://www.w3.org/2000/svg"
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
                    <span class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Revisi</span>
                    <span class="text-lg font-bold text-orange-600 dark:text-orange-500">
                        {{ $performanceMetrics['avg_revision'] ?? 0 }}
                    </span>
                </div>
            </div>

            <div class="pt-2 border-t border-gray-200 dark:border-neutral-700">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600 dark:text-gray-400">Dalam Revisi</span>
                    <span class="text-lg font-bold text-red-600 dark:text-red-500">
                        {{ $performanceMetrics['in_revision'] ?? 0 }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Queue List -->
    <div
        class="lg:col-span-2 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 10 7.894 14.162a1 1 0 0 0 1.8-1.342L15 10" />
                    <path d="M21 10V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-5" />
                </svg>
                Antrian Aktif
            </h2>
        </div>
        <div class="p-4 space-y-3 max-h-80 overflow-y-auto">
            @forelse($queueInfo['items'] ?? [] as $queue)
                <div
                    class="flex items-center justify-between p-3 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-900/10 rounded-lg border border-blue-200 dark:border-blue-800/50 hover:shadow-md transition">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex items-center justify-center h-8 w-8 rounded-full bg-blue-600 dark:bg-blue-500 text-white font-bold text-sm">
                            {{ $queue->antrian_ke ?? 0 }}
                        </div>
                        <div>
                            <p class="font-medium text-sm text-gray-900 dark:text-white">
                                {{ $queue->customer_name ?? 'N/A' }}
                            </p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ $queue->workType->work_type ?? 'N/A' }}
                            </p>
                        </div>
                    </div>
                    <span
                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 dark:bg-blue-900/50 text-blue-800 dark:text-blue-300">
                        Ke-{{ $queue->antrian_ke ?? 0 }}
                    </span>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada item antrian</p>
            @endforelse
        </div>
    </div>
</div>

<!-- Status Breakdown & Recent Work Orders -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
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
                    $dotColor = match ($item['status']) {
                        'validate' => '#fbbf24',
                        'queue' => '#3b82f6',
                        'pending' => '#f97316',
                        'progress' => '#06b6d4',
                        'revision' => '#ef4444',
                        'migration' => '#8b5cf6',
                        'finish' => '#10b981',
                        default => '#6b7280',
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

    <!-- Recent Work Orders -->
    <div
        class="lg:col-span-2 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-indigo-600 dark:text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M13 2H3v20h18V8z" />
                    <polyline points="13 2 13 8 19 8" />
                </svg>
                Pekerjaan Terbaru
            </h2>
        </div>
        <div class="p-4 space-y-3 max-h-80 overflow-y-auto">
            @forelse($recentWorkOrders ?? [] as $workOrder)
                @php
                    $statusColors = [
                        'validate' => ['border' => '#fbbf24', 'bg' => '#fef3c7', 'text' => '#92400e'],
                        'queue' => ['border' => '#3b82f6', 'bg' => '#dbeafe', 'text' => '#1e40af'],
                        'pending' => ['border' => '#f97316', 'bg' => '#fed7aa', 'text' => '#9a3412'],
                        'progress' => ['border' => '#06b6d4', 'bg' => '#cffafe', 'text' => '#0e7490'],
                        'revision' => ['border' => '#ef4444', 'bg' => '#fee2e2', 'text' => '#7f1d1d'],
                        'migration' => ['border' => '#8b5cf6', 'bg' => '#ede9fe', 'text' => '#5b21b6'],
                        'finish' => ['border' => '#10b981', 'bg' => '#d1fae5', 'text' => '#065f46'],
                    ];
                    $colors = $statusColors[$workOrder->status] ?? [
                        'border' => '#6b7280',
                        'bg' => '#f3f4f6',
                        'text' => '#374151',
                    ];
                @endphp
                <div class="flex items-start justify-between gap-3 p-3 bg-gray-50 dark:bg-neutral-700/50 rounded-lg border-l-4"
                    style="border-color: {{ $colors['border'] }}">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-gray-900 dark:text-white truncate">
                            {{ $workOrder->customer?->name ?? 'Unknown' }}
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            {{ $workOrder->workType?->work_type ?? 'Unknown Type' }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold"
                            style="background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}">
                            {{ $workOrder->status_display ?? ucfirst($workOrder->status) }}
                        </span>
                        <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                            {{ $workOrder->time_ago ?? '-' }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">Tidak ada pekerjaan terbaru</p>
            @endforelse
        </div>
    </div>
</div>
