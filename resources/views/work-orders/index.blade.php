@extends('layouts.app')

@section('content')

    <!-- Page Wrapper -->
    <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14">

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
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">Work Orders</h2>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">Daftar Work Order lengkap beserta
                                    relasinya.</p>
                            </div>

                            @role('asservice')
                                <div class="flex justify-end gap-x-2">
                                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                        href="{{ route('asservice.work-orders.create') }}">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                        </svg>
                                        Tambah Work Order
                                    </a>
                                </div>
                            @endrole
                        </div>
                        <!-- End Header -->

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
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Antrian
                                                    Ke</span>
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
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Estimasi</span>
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
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Received</span>
                                            </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Completed</span>
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
                                                        {{ $loop->iteration }}
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
                                                    @if ($order->status === 'completed')
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                                            </svg>
                                                            Completed
                                                        </span>
                                                    @elseif($order->status === 'revision')
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-orange-100 text-orange-800 rounded-full dark:bg-orange-500/10 dark:text-orange-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                                            </svg>
                                                            Revision
                                                        </span>
                                                    @else
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full dark:bg-blue-500/10 dark:text-blue-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                            </svg>
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
                                                    <span class="text-sm text-gray-700 dark:text-neutral-300"
                                                        title="Estimasi: {{ $order->calculated_estimation_days }} hari">
                                                        {{ $order->calculated_estimation ?? '-' }}
                                                    </span>
                                                    @if ($order->calculated_estimation != $order->estimasi_date)
                                                        <span class="text-xs text-orange-500 ml-1"
                                                            title="Estimasi terupdate">
                                                            ↆ
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Info Tambahan -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3">
                                                    <span
                                                        class="text-xs {{ $order->fast_track ? 'bg-yellow-100 text-yellow-800' : 'bg-blue-100 text-blue-800' }} px-2 py-1 rounded-full">
                                                        {{ $order->fast_track ? 'Fast Track' : 'Regular' }}
                                                    </span>
                                                    <span class="text-xs text-gray-500 ml-1">
                                                        {{ $order->calculated_estimation_days }} hari
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
                                                    <div
                                                        class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                                                        <button
                                                            class="hs-dropdown-toggle py-1.5 px-2 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                                                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
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
                                                                <a href="{{ route($prefix .'work-orders.show', $order->id) }}"
                                                                    class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700 dark:hover:text-neutral-300 dark:focus:bg-neutral-700">
                                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16" fill="currentColor"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                                    </svg>
                                                                    Detail
                                                                </a>

                                                                @role('asservice')
                                                                    <!-- Edit -->
                                                                    <a href="{{ route('asservice.work-orders.edit', $order->id) }}"
                                                                        class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-blue-600 hover:bg-blue-100 focus:outline-hidden focus:bg-blue-100 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:bg-blue-500/10">
                                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16" fill="currentColor"
                                                                            viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                                                        </svg>
                                                                        Edit
                                                                    </a>

                                                                    <!-- Button Delete Baru -->
                                                                    <button type="button"
                                                                        class="delete-workorder-btn flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-100 focus:outline-hidden focus:bg-red-100 dark:text-red-500 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 w-full"
                                                                        data-workorder-id="{{ $order->id }}"
                                                                        data-ref-id="{{ $order->ref_id }}"
                                                                        data-customer="{{ $order->customer->name }}"
                                                                        data-division="{{ $order->division->name ?? '-' }}"
                                                                        data-worktype="{{ $order->workType->work_type ?? '-' }}"
                                                                        data-status="{{ $order->status }}"
                                                                        data-queue="{{ $order->antrian_ke }}"
                                                                        data-hs-overlay="#hs-delete-workorder-modal">
                                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="16" fill="currentColor"
                                                                            viewBox="0 0 16 16">
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
                                </tbody>
                            </table>
                            <!-- End Table -->
                        @else
                            <!-- Empty State -->
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
                                    Mulai dengan menambahkan Work Order baru untuk mengisi data.
                                </p>
                            </div>
                            <!-- End Empty State -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- End Card -->

    </div>
    <!-- End Page Wrapper -->

@endsection

<script>
    // resources/js/work-queue.js
    class WorkQueueUpdater {
        constructor() {
            this.updateInterval = 30000; // 30 detik
            this.init();
        }

        init() {
            this.loadQueueData();
            setInterval(() => this.loadQueueData(), this.updateInterval);
        }

        async loadQueueData() {
            try {
                const response = await fetch('/api/work-orders/queue-estimations');
                const data = await response.json();

                if (data.success) {
                    this.updateUI(data.data);
                }
            } catch (error) {
                console.error('Error fetching queue data:', error);
            }
        }

        updateUI(orders) {
            orders.forEach(order => {
                // Update estimasi di UI
                const estimasiElement = document.querySelector(
                    `[data-order-id="${order.id}"] .estimasi-date`);
                if (estimasiElement) {
                    estimasiElement.textContent = order.estimated_date;

                    // Highlight jika berbeda dengan database
                    if (order.estimated_date !== order.current_estimasi_date) {
                        estimasiElement.classList.add('text-orange-600', 'font-semibold');
                    }
                }
            });
        }
    }

    // Inisialisasi
    document.addEventListener('DOMContentLoaded', function() {
        new WorkQueueUpdater();
    });
</script>
