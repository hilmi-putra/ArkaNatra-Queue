<!-- AsService Dashboard with Preline CSS Cards - Modern Design -->

<!-- Key Metrics Cards - 4 Column Layout -->
<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6">
    <!-- Total Created Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Total Dibuat</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-gray-800 dark:text-neutral-200">
                        {{ $metrics['total_created'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-indigo-50 dark:bg-indigo-900/30">
                        <svg class="size-6 text-indigo-600 dark:text-indigo-500" xmlns="http://www.w3.org/2000/svg"
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

    <!-- Validating Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Validasi</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-yellow-600 dark:text-yellow-500">
                        {{ $metrics['total_validating'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-yellow-50 dark:bg-yellow-900/30">
                        <svg class="size-6 text-yellow-600 dark:text-yellow-500" xmlns="http://www.w3.org/2000/svg"
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

    <!-- Queue Work Orders Card -->
    <div
        class="group flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl hover:shadow-md focus:outline-hidden focus:shadow-md transition dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5">
            <div class="flex items-start justify-between gap-x-4">
                <div class="grow">
                    <p class="text-xs uppercase tracking-wide text-gray-500 dark:text-neutral-500 font-semibold">
                        Antrian</p>
                    <p class="mt-2 text-2xl sm:text-3xl font-bold text-blue-600 dark:text-blue-500">
                        {{ $metrics['total_queue'] ?? 0 }}
                    </p>
                </div>
                <div class="flex-shrink-0">
                    <span
                        class="inline-flex items-center justify-center h-11 w-11 rounded-lg bg-blue-50 dark:bg-blue-900/30">
                        <svg class="size-6 text-blue-600 dark:text-blue-500" xmlns="http://www.w3.org/2000/svg"
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
</div>

<!-- Status Breakdown & Priority Items -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Status Breakdown Chart -->
    <div
        class="lg:col-span-1 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-purple-600 dark:text-purple-500" xmlns="http://www.w3.org/2000/svg"
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
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
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

    <!-- Priority Items List -->
    <div
        class="lg:col-span-2 flex flex-col bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <div class="p-4 md:p-5 border-b border-gray-200 dark:border-neutral-700">
            <h2 class="text-base font-semibold text-gray-800 dark:text-neutral-200 flex items-center gap-2">
                <svg class="size-5 text-red-600 dark:text-red-500" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z" />
                    <line x1="12" x2="12" y1="9" y2="13" />
                    <line x1="12" x2="12.01" y1="17" y2="17" />
                </svg>
                Memerlukan Perhatian
            </h2>
        </div>
        <div class="p-4 space-y-3 max-h-96 overflow-y-auto">
            @forelse($priorityItems ?? [] as $item)
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
                    $colors = $statusColors[$item->status] ?? ['border' => '#6b7280', 'bg' => '#f3f4f6', 'text' => '#374151'];
                @endphp
                <div class="flex items-start justify-between gap-3 p-3 bg-gray-50 dark:bg-neutral-700/50 rounded-lg border-l-4" 
                    style="border-color: {{ $colors['border'] }}">
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm text-gray-900 dark:text-white truncate">
                            {{ $item->customer?->name ?? 'Unknown' }}
                        </p>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            {{ $item->workType?->work_type ?? 'Unknown Type' }}
                        </p>
                        <p class="text-xs text-red-600 dark:text-red-400 font-semibold mt-1">
                            {{ $item->priority_reason }}
                        </p>
                    </div>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold" 
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

<!-- Recent Work Orders Table -->
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
            Pekerjaan Terbaru
        </h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full divide-y divide-gray-200 dark:divide-neutral-700">
            <thead class="bg-gray-50 dark:bg-neutral-700/50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Customer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Jenis Pekerjaan</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-600 dark:text-neutral-300">
                        Waktu</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                @forelse($recentWorkOrders ?? [] as $workOrder)
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
                        $colors = $statusColors[$workOrder->status] ?? ['bg' => '#f3f4f6', 'text' => '#374151'];
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-neutral-700/50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $workOrder->customer?->name ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            {{ $workOrder->workType?->work_type ?? 'Unknown' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold"
                                style="background-color: {{ $colors['bg'] }}; color: {{ $colors['text'] }}">
                                {{ $workOrder->status_display ?? ucfirst($workOrder->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $workOrder->time_ago ?? '-' }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                            Tidak ada pekerjaan terbaru
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>