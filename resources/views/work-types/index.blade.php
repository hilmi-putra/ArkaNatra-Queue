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
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">
                                    Work Types
                                </h2>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">
                                    Daftar jenis pekerjaan beserta estimasi dan relasinya.
                                </p>
                            </div>

                            @role('admin')
                                <div class="flex justify-end gap-x-2">
                                    <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                        href="{{ route('admin.work-types.create') }}">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 12h14" />
                                            <path d="M12 5v14" />
                                        </svg>
                                        Tambah Work Type
                                    </a>
                                </div>
                            @endrole
                        </div>
                        <!-- End Header -->

                        @if ($data->count())
                            <!-- Table -->
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                <thead class="bg-gray-50 dark:bg-neutral-800">
                                    <tr>
                                        <th class="ps-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">No</span>
                                        </th>

                                        <th class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Work
                                                Type</span>
                                        </th>

                                        <th class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Regular
                                                Estimation (Days)</span>
                                        </th>

                                        <th class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Extra
                                                Days per Qty</span>
                                        </th>

                                        <th class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Fast
                                                Track (Days)</span>
                                        </th>

                                        <th class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Division</span>
                                        </th>

                                        <th class="px-6 py-3 text-start">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Work
                                                Orders</span>
                                        </th>

                                        <th class="px-6 py-3 text-end">
                                            <span
                                                class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @foreach ($data as $type)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800">

                                            <!-- No -->
                                            <td class="ps-6 py-3">
                                                <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>

                                            <!-- Work Type Name -->
                                            <td class="px-6 py-3">
                                                <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                                    {{ $type->work_type }}
                                                </span>
                                            </td>

                                            <!-- Regular Estimation Days -->
                                            <td class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $type->regular_estimation_days }}
                                                </span>
                                            </td>

                                            <!-- Extra Days per Quantity -->
                                            <td class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $type->extra_days_per_quantity }}
                                                </span>
                                            </td>

                                            <!-- Fast Track Estimation -->
                                            <td class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $type->fast_track_estimation_days }}
                                                </span>
                                            </td>

                                            <!-- Division -->
                                            <td class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $type->division->name ?? '-' }}
                                                </span>
                                            </td>

                                            <!-- Work Orders Count -->
                                            <td class="px-6 py-3">
                                                <span class="text-sm text-gray-700 dark:text-neutral-300">
                                                    {{ $type->workOrders->count() }}
                                                </span>
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
                                                                <!-- Edit -->
                                                                <a href="{{ route('admin.work-types.edit', $type->id) }}"
                                                                    class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-blue-600 hover:bg-blue-100 focus:outline-hidden focus:bg-blue-100 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:bg-blue-500/10">
                                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16" fill="currentColor"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                                                    </svg>
                                                                    Edit
                                                                </a>

                                                                <!-- Delete -->
                                                                <button type="button"
                                                                    class="delete-work-type-btn flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-100 focus:outline-hidden focus:bg-red-100 dark:text-red-500 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 w-full"
                                                                    data-hs-overlay="#hs-delete-work-type-modal"
                                                                    data-work-type-id="{{ $type->id }}"
                                                                    data-work-type-name="{{ $type->work_type }}"
                                                                    data-work-type-division="{{ $type->division->name ?? '-' }}"
                                                                    data-work-type-regular="{{ $type->regular_estimation_days }}"
                                                                    data-work-type-extra="{{ $type->extra_days_per_quantity }}">
                                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16" fill="currentColor"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                                                    </svg>
                                                                    Hapus
                                                                </button>
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
                            <div class="max-w-sm w-full mx-auto px-6 py-16 text-center">
                                <div
                                    class="size-14 mx-auto flex justify-center items-center bg-gray-100 rounded-lg dark:bg-neutral-800">
                                    <svg class="size-7 text-gray-600 dark:text-neutral-400"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Z" />
                                        <path d="M12 14c0 1-1 1-1 1H5s-1 0-1-1 1-4 4-4 4 3 4 4Z" />
                                    </svg>
                                </div>
                                <h2 class="mt-5 text-gray-800 font-semibold dark:text-white">
                                    Tidak ada Work Type
                                </h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                                    Tambahkan Work Type baru untuk mengisi data.
                                </p>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
