@extends('layouts.app')

@section('content')
    <!-- Page Wrapper -->
    <!-- Status Overview Cards -->
    <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        @php
            $role = auth()->user()->getRoleNames()->first();
            $prefix = '';

            if ($role === 'admin') {
                $prefix = 'admin.';
            } elseif ($role === 'production') {
                $prefix = 'production.';
            } elseif ($role === 'sales') {
                $prefix = 'sales.';
            } elseif ($role === 'asservice') {
                $prefix = 'asservice.';
            }

            $statuses = [
                'validate' => [
                    'label' => 'Validate',
                    'color' => 'blue',
                    'count' => $statusCounts['validate'] ?? 0,
                    'icon' => '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
                'queue' => [
                    'label' => 'Queue',
                    'color' => 'purple',
                    'count' => $statusCounts['queue'] ?? 0,
                    'icon' => '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
                'pending' => [
                    'label' => 'Pending',
                    'color' => 'yellow',
                    'count' => $statusCounts['pending'] ?? 0,
                    'icon' => '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
                'progress' => [
                    'label' => 'Progress',
                    'color' => 'indigo',
                    'count' => $statusCounts['progress'] ?? 0,
                    'icon' => '<path d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                ],
                'revision' => [
                    'label' => 'Revision',
                    'color' => 'red',
                    'count' => $statusCounts['revision'] ?? 0,
                    'icon' =>
                        '<path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
                ],
                'migration' => [
                    'label' => 'Migration',
                    'color' => 'orange',
                    'count' => $statusCounts['migration'] ?? 0,
                    'icon' => '<path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>',
                ],
                'finish' => [
                    'label' => 'Finish',
                    'color' => 'green',
                    'count' => $statusCounts['finish'] ?? 0,
                    'icon' => '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                ],
            ];

            $colorClasses = [
                'blue' => [
                    'bg' => 'bg-blue-600',
                    'text' => 'text-blue-600 dark:text-blue-500',
                    'card_bg' => 'bg-blue-50 dark:bg-blue-900/20',
                ],
                'purple' => [
                    'bg' => 'bg-purple-600',
                    'text' => 'text-purple-600 dark:text-purple-500',
                    'card_bg' => 'bg-purple-50 dark:bg-purple-900/20',
                ],
                'yellow' => [
                    'bg' => 'bg-yellow-500',
                    'text' => 'text-yellow-600 dark:text-yellow-500',
                    'card_bg' => 'bg-yellow-50 dark:bg-yellow-900/20',
                ],
                'indigo' => [
                    'bg' => 'bg-indigo-600',
                    'text' => 'text-indigo-600 dark:text-indigo-500',
                    'card_bg' => 'bg-indigo-50 dark:bg-indigo-900/20',
                ],
                'red' => [
                    'bg' => 'bg-red-600',
                    'text' => 'text-red-600 dark:text-red-500',
                    'card_bg' => 'bg-red-50 dark:bg-red-900/20',
                ],
                'orange' => [
                    'bg' => 'bg-orange-500',
                    'text' => 'text-orange-600 dark:text-orange-500',
                    'card_bg' => 'bg-orange-50 dark:bg-orange-900/20',
                ],
                'green' => [
                    'bg' => 'bg-green-600',
                    'text' => 'text-green-600 dark:text-green-500',
                    'card_bg' => 'bg-green-50 dark:bg-green-900/20',
                ],
            ];
        @endphp

        <!-- Grid -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7 gap-6">
            @foreach ($statuses as $statusKey => $statusInfo)
                <!-- Card -->
                <a href="{{ route($prefix . 'work-orders.status.' . $statusKey) }}"
                    class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-xl hover:shadow-lg transition-all duration-300 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <!-- Header with colored background -->
                    <div
                        class="h-32 flex flex-col justify-center items-center {{ $colorClasses[$statusInfo['color']]['bg'] }} rounded-t-xl">
                        <div class="p-3 rounded-lg bg-white/20 backdrop-blur-sm">
                            <svg class="size-10 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                {!! $statusInfo['icon'] !!}
                            </svg>
                        </div>
                    </div>

                    <!-- Card Content -->
                    <div class="p-4 md:p-5 flex-1 flex flex-col">
                        <!-- Status Label -->
                        <span
                            class="block mb-2 text-xs font-semibold uppercase {{ $colorClasses[$statusInfo['color']]['text'] }}">
                            {{ $statusInfo['label'] }}
                        </span>

                        <!-- Count -->
                        <h3 class="text-2xl font-bold text-gray-800 dark:text-neutral-300 mb-3">
                            {{ $statusInfo['count'] }}
                        </h3>

                        <!-- Progress Bar -->
                        @php
                            $totalOrders = array_sum(array_column($statuses, 'count'));
                            $percentage = $totalOrders > 0 ? ($statusInfo['count'] / $totalOrders) * 100 : 0;
                        @endphp
                        <div class="mt-auto space-y-2">
                            <div class="flex justify-between text-sm text-gray-600 dark:text-neutral-400">
                                <span>Progress</span>
                                <span class="font-semibold {{ $colorClasses[$statusInfo['color']]['text'] }}">
                                    {{ number_format($percentage, 1) }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2 dark:bg-neutral-700">
                                <div class="h-2 rounded-full {{ $colorClasses[$statusInfo['color']]['bg'] }}"
                                    style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer with view button -->
                    <div class="border-t border-gray-200 dark:border-neutral-700">
                        <div class="p-4 md:p-5">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                    View details
                                </span>
                                <svg class="size-4 {{ $colorClasses[$statusInfo['color']]['text'] }} opacity-0 group-hover:opacity-100 transition-opacity"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="m9 18 6-6-6-6" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>
                <!-- End Card -->
            @endforeach
        </div>
        <!-- End Grid -->
    </div>
    <!-- End Status Overview Cards -->

    <!-- Card Wrapper -->
    <div class="flex flex-col">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-2xs overflow-hidden dark:bg-neutral-900 dark:border-neutral-700">

                    <!-- Header -->
                    <div
                        class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200 dark:border-neutral-700">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">Work Orders Overview
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-neutral-400">Ringkasan seluruh Work Order. Klik
                                kartu status di atas untuk melihat detail.</p>
                        </div>

                        <div class="flex justify-end gap-x-2">
                            @role('asservice')
                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                    href="{{ route('asservice.work-orders.create') }}">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16"
                                        height="16" fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>
                                    Tambah Work Order
                                </a>
                            @endrole
                        </div>
                    </div>
                    <!-- End Header -->

                    <!-- Info Box -->
                    <div class="px-6 py-4 bg-blue-50 dark:bg-blue-900/10 border-b border-blue-200 dark:border-blue-800">
                        <p class="text-sm text-blue-700 dark:text-blue-300">
                            <strong>Catatan:</strong> Halaman ini menampilkan ringkasan semua Work Order. Untuk melihat
                            dan mengelola Work Order berdasarkan status, gunakan menu <strong>"Work Orders"</strong> di
                            sidebar dan pilih status yang diinginkan.
                        </p>
                    </div>

                    @if ($data->count() > 0)
                        <!-- Table -->
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                            <thead class="bg-gray-50 dark:bg-neutral-800">
                                <tr>
                                    <th scope="col" class="ps-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">No</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Ref
                                                ID</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Customer</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Marketing
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">
                                                Production
                                            </span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Status</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Qty</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Fast
                                                Track</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-start">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Tgl
                                                Diterima</span>
                                        </div>
                                    </th>

                                    <th scope="col" class="px-6 py-3 text-end">
                                        <div class="flex items-center gap-x-2">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Aksi</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">

                                @foreach ($data as $order)
                                    <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800">
                                        <td class="size-px whitespace-nowrap">
                                            <div class="ps-6 py-3">
                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                   {{ $loop->iteration }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                                    {{ $order->ref_id }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $order->customer->name ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $order->salesUser->name ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $order->productionUser->name ?? '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span
                                                    class="text-xs font-semibold px-2 py-1 rounded-full 
                                                        @if ($order->status === 'validate') bg-blue-100 text-blue-800
                                                        @elseif($order->status === 'queue') bg-purple-100 text-purple-800
                                                        @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                        @elseif($order->status === 'progress') bg-indigo-100 text-indigo-800
                                                        @elseif($order->status === 'revision') bg-red-100 text-red-800
                                                        @elseif($order->status === 'migration') bg-orange-100 text-orange-800
                                                        @elseif($order->status === 'finish') bg-green-100 text-green-800 @endif">
                                                    {{ ucfirst($order->status) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $order->quantity }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span
                                                    class="text-xs {{ $order->fast_track ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }} px-2 py-1 rounded-full">
                                                    {{ $order->fast_track ? 'Yes' : 'No' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $order->date_received ?: '-' }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="size-px whitespace-nowrap">
                                            <div class="px-6 py-3">
                                                <a href="{{ route($prefix . 'work-orders.show', $order->id) }}"
                                                    class="inline-flex items-center justify-center size-8 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 hover:shadow-lg focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 transition-all duration-200"
                                                    title="View Details">
                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="10" />
                                                        <path d="M12 16v-4" />
                                                        <path d="M12 8h.01" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- End Table -->
                    @else
                        <tr>
                            <td colspan="10" class="text-center py-10">
                                <div class="max-w-sm w-full min-h-100 flex flex-col justify-center mx-auto px-6 py-4">
                                    <div
                                        class="flex justify-center items-center size-11 bg-gray-100 rounded-lg dark:bg-neutral-800">
                                        <svg class="shrink-0 size-6 text-gray-600 dark:text-neutral-400"
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                                        </svg>
                                    </div>

                                    <h2 class="mt-5 font-semibold text-gray-800 dark:text-white">
                                        Tidak ada data Work Order
                                    </h2>
                                    <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                                        Belum ada Work Order yang tersedia.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    </div>
    <!-- End Page Wrapper -->
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-initialize Preline components
            window.HSStaticMethods.autoInit();
        });
    </script>
@endsection
