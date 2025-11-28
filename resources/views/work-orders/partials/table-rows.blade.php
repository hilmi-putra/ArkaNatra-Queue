@if ($data->count() > 0)
    @foreach ($data as $order)
        <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800">

            <!-- No -->
            <td class="size-px whitespace-nowrap">
                <div class="ps-6 py-3">
                    <span class="text-sm text-gray-600 dark:text-neutral-400">
                        {{ $loop->iteration }}
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

            <!-- Antrian Ke -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                        {{ $order->status !== 'validate' ? $order->antrian_ke : '-' }}
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

            <!-- PIC User -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->salesUser->name ?? '-' }}
                    </span>
                </div>
            </td>

            <!-- PIC User -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->productionUser->name ?? '-' }}
                    </span>
                </div>
            </td>

            <!-- Status -->
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

            <!-- Quantity -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->quantity }}
                    </span>
                </div>
            </td>

            <!-- Estimasi -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->status !== 'validate' && $order->estimasi_date ? $order->estimasi_date : '-' }}
                    </span>
                </div>
            </td>

            <!-- Info Tambahan -->
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
                        {{ $order->date_received ?? '-' }}
                    </span>
                </div>
            </td>

            <!-- Date Completed -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-3">
                    <span class="text-sm text-gray-700 dark:text-neutral-300">
                        {{ $order->date_completed ?? '-' }}
                    </span>
                </div>
            </td>

            <!-- Actions -->
            <td class="size-px whitespace-nowrap">
                <div class="px-6 py-1.5 flex justify-end">
                    <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                        <button
                            class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" viewBox="0 0 16 16">
                                <path
                                    d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3z" />
                            </svg>
                        </button>

                        <div
                            class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden divide-y divide-gray-200 min-w-40 z-10 bg-white shadow-2xl rounded-lg p-2 mt-2 dark:divide-neutral-700 dark:bg-neutral-800 dark:border dark:border-neutral-700">
                            <div class="py-2 first:pt-0 last:pb-0">

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
                                    class="copy-customer-info-btn flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-green-600 hover:bg-green-100 focus:outline-hidden focus:bg-green-100 dark:text-green-500 dark:hover:bg-green-500/10 dark:focus:bg-green-500/10 w-full"
                                    data-ref-id="{{ $order->ref_id }}"
                                    data-token="{{ $order->customer->token ?? 'N/A' }}"
                                    data-url="http://127.0.0.1:8000/">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                        <path
                                            d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                    </svg>
                                    Copy Info
                                </button>

                                <a href="{{ route($prefix . 'work-orders.show', $order->id) }}"
                                    class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700">
                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                    </svg>
                                    Detail
                                </a>


                                @hasanyrole('asservice|production')
                                    <!-- Edit -->
                                    <a href="{{ route('asservice.work-orders.edit', $order->id) }}"
                                        class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-blue-600 hover:bg-blue-100 focus:outline-hidden focus:bg-blue-100 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:bg-blue-500/10">
                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                        </svg>
                                        Edit
                                    </a>
                                @endhasanyrole

                                @role('asservice')
                                    <!-- Button Delete Baru -->
                                    <button type="button"
                                        class="delete-workorder-btn flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-100 focus:outline-hidden focus:bg-red-100 dark:text-red-500 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 w-full"
                                        data-workorder-id="{{ $order->id }}" data-ref-id="{{ $order->ref_id }}"
                                        data-customer="{{ $order->customer->name }}"
                                        data-division="{{ $order->division->name ?? '-' }}"
                                        data-worktype="{{ $order->workType->work_type ?? '-' }}"
                                        data-status="{{ $order->status }}" data-queue="{{ $order->antrian_ke }}"
                                        data-hs-overlay="#hs-delete-workorder-modal">
                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                        </svg>
                                        Hapus
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
        <td colspan="13" class="text-center py-10">
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
                    Tidak ada data Work Order yang cocok
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                    Coba ubah filter Anda atau tambahkan Work Order baru.
                </p>
            </div>
        </td>
    </tr>
@endif
