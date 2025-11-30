@php
    $showAntrian = $showAntrian ?? false;
    $columnCount = $showAntrian ? 10 : 9;
@endphp

@if ($data->count() > 0)
    @foreach ($data as $order)
        <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800">

            <!-- No -->
            <td class="size-px whitespace-nowrap">
                <div class="ps-6 py-3">
                    <span class="text-sm text-gray-600 dark:text-neutral-400">
                        {{ $data->firstItem() + $loop->index }}
                    </span>
                </div>
            </td>

            <!-- Ref ID -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                        {{ $order->ref_id }}
                    </span>
                </div>
            </td>

            @if ($showAntrian)
                <!-- Antrian Ke -->
                <td class="size-px whitespace-nowrap">
                    <div class="px-6 py-3">
                        <span class="text-sm text-gray-700 dark:text-neutral-300">
                            {{ $order->antrian_ke ?? '-' }}
                        </span>
                    </div>
                </td>
            @endif

            <!-- Customer -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->customer->name ?? '-' }}
                    </span>
                </div>
            </td>

            <!-- Marketing -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->salesUser->name ?? '-' }}
                    </span>
                </div>
            </td>

            <!-- Production -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->productionUser->name ?? '-' }}
                    </span>
                </div>
            </td>

            <!-- Quantity -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->quantity }}
                    </span>
                </div>
            </td>

            <!-- Status Column with Inline Dropdown -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    @php
                        $statuses = ['validate', 'queue', 'pending', 'progress', 'revision', 'migration', 'finish'];
                        $statusColors = [
                            'validate' => ['bg-gray-100', 'text-gray-800'],
                            'queue' => ['bg-blue-100', 'text-blue-800'],
                            'pending' => ['bg-yellow-100', 'text-yellow-800'],
                            'progress' => ['bg-indigo-100', 'text-indigo-800'],
                            'revision' => ['bg-orange-100', 'text-orange-800'],
                            'migration' => ['bg-purple-100', 'text-purple-800'],
                            'finish' => ['bg-teal-100', 'text-teal-800'],
                        ];
                        $currentColor = $statusColors[$order->status] ?? ['bg-gray-100', 'text-gray-800'];
                    @endphp

                    @if (auth()->user()->hasRole('production'))
                        <div class="hs-dropdown relative inline-flex">
                            <button id="hs-dropdown-status-{{ $order->id }}" type="button"
                                class="hs-dropdown-toggle py-1 ps-1 pe-3 inline-flex items-center gap-x-2 text-xs font-medium rounded-full {{ $currentColor[0] }} {{ $currentColor[1] }}">
                                <span class="py-0.5 px-2 rounded-full bg-white text-gray-800">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <svg class="hs-dropdown-open:rotate-180 size-2.5" width="16" height="16"
                                    viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 5L8.16086 10.6869C8.35239 10.8637 8.64761 10.8637 8.83914 10.6869L15 5"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                                </svg>
                            </button>
                            <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-40 bg-white shadow-md rounded-lg p-2 mt-2 dark:bg-neutral-800 dark:border dark:border-neutral-700 dark:divide-neutral-700 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full z-20"
                                aria-labelledby="hs-dropdown-status-{{ $order->id }}">
                                @foreach ($statuses as $status)
                                    <a class="status-update-btn flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:ring-2 focus:ring-blue-500 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300"
                                        href="#" data-order-id="{{ $order->id }}"
                                        data-status="{{ $status }}">
                                        {{ ucfirst($status) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <span
                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-full {{ $currentColor[0] }} {{ $currentColor[1] }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    @endif
                </div>
            </td>

            <!-- Fast Track -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span
                        class="text-xs {{ $order->fast_track ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }} px-2 py-1 rounded-full">
                        {{ $order->fast_track ? 'Fast Track' : 'Regular' }}
                    </span>
                </div>
            </td>

            <!-- Date Received -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->date_received ? $order->date_received : '-' }}
                    </span>
                </div>
            </td>

            <!-- Actions -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                        <button
                            class="hs-dropdown-toggle inline-flex items-center justify-center size-8 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 hover:shadow-lg focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 transition-all duration-200">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="12" cy="12" r="1" />
                                <circle cx="12" cy="5" r="1" />
                                <circle cx="12" cy="19" r="1" />
                            </svg>
                        </button>

                        <div
                            class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-44 z-20 bg-white shadow-xl rounded-xl p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700">
                            <div class="py-2 first:pt-0 last:pb-0 space-y-1">

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
                                @endphp

                                <!-- Tombol Copy -->
                                <button type="button"
                                    class="copy-customer-info-btn flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700 w-full transition-colors duration-200"
                                    data-ref-id="{{ e($order->ref_id ?? '') }}"
                                    data-token="{{ e($order->customer->token ?? '') }}"
                                    data-customer-name="{{ e($order->customer->name ?? '') }}"
                                    data-customer-email="{{ e($order->customer->email ?? '') }}"
                                    data-url="{{ e(url('/')) }}">
                                    <svg class="size-4 text-green-600" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <rect x="9" y="9" width="13" height="13" rx="2" ry="2" />
                                        <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1" />
                                    </svg>
                                    Copy Info
                                </button>

                                <!-- Tombol Detail -->
                                <a href="{{ route($prefix . 'work-orders.show', $order->id) }}"
                                    class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700 w-full transition-colors duration-200">
                                    <svg class="size-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                    View Details
                                </a>

                                @hasanyrole('asservice|production')
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('asservice.work-orders.edit', $order->id) }}"
                                        class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-300 dark:hover:bg-neutral-700 w-full transition-colors duration-200">
                                        <svg class="size-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                        Edit
                                    </a>
                                @endhasanyrole

                                @role('asservice')
                                    <!-- Tombol Delete -->
                                    <button type="button"
                                        class="delete-workorder-btn flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-700 hover:bg-red-50 hover:text-red-700 focus:outline-hidden focus:bg-red-50 focus:text-red-700 dark:text-neutral-300 dark:hover:bg-red-500/10 dark:hover:text-red-400 w-full transition-colors duration-200"
                                        data-workorder-id="{{ $order->id }}" data-ref-id="{{ $order->ref_id }}"
                                        data-customer="{{ $order->customer->name }}"
                                        data-division="{{ $order->division->name ?? '-' }}"
                                        data-worktype="{{ $order->workType->work_type ?? '-' }}"
                                        data-status="{{ $order->status }}" data-queue="{{ $order->antrian_ke }}"
                                        data-hs-overlay="#hs-delete-workorder-modal">
                                        <svg class="size-4 text-red-600" xmlns="http://www.w3.org/2000/svg"
                                            width="24" height="24" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path d="M3 6h18" />
                                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                        </svg>
                                        Delete
                                    </button>
                                @endrole
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="{{ $columnCount }}" class="text-center py-10">
            <div class="max-w-sm w-full min-h-100 flex flex-col justify-center mx-auto px-6 py-4">
                <div class="flex justify-center items-center size-11 bg-gray-100 rounded-lg dark:bg-neutral-800">
                    <svg class="shrink-0 size-6 text-gray-600 dark:text-neutral-400"
                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        viewBox="0 0 16 16">
                        <path
                            d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                    </svg>
                </div>

                <h2 class="mt-5 font-semibold text-gray-800 dark:text-white">
                    Tidak ada data Work Order pada status ini
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                    Belum ada Work Order dengan status ini atau tidak ada yang sesuai dengan role Anda.
                </p>
            </div>
        </td>
    </tr>
@endif
