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

            <!-- Status -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span
                        class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium rounded-full bg-red-100 text-red-800 dark:bg-red-500/20 dark:text-red-400">
                        <svg class="shrink-0 size-3" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10" />
                            <path d="M8 12h8" />
                        </svg>
                        Cancelled
                    </span>
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

            <!-- Date Cancelled -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->date_cancelled ? $order->date_cancelled : '-' }}
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
        <td colspan="10" class="text-center py-8">
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
