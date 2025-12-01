@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Recycle Bin</h1>
            <p class="text-lg text-gray-600 dark:text-neutral-400">Restore or permanently delete items</p>
        </div>

        <!-- Summary Cards -->
        @if ($modelType === 'all')
            <!-- Total Items Card -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div
                    class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                    <div class="h-32 flex flex-col justify-center items-center bg-gray-600 rounded-t-xl">
                        <svg class="size-16 text-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        </svg>
                    </div>
                    <div class="p-4 md:p-6 text-center">
                        <span class="block text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400 mb-1">
                            Total Trashed Items
                        </span>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-neutral-300">
                            {{ $totalItems }}
                        </h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-neutral-500">
                            Items waiting for restoration or permanent deletion
                        </p>
                    </div>
                </div>

                <!-- Category Cards -->
                @forelse($trashedItems as $modelName => $stats)
                    @php
                        // Tentukan warna berdasarkan model name
                        $colors = [
                            'WorkOrder' => ['bg' => 'bg-blue-600', 'text' => 'text-blue-600 dark:text-blue-500'],
                            'User' => ['bg' => 'bg-green-600', 'text' => 'text-green-600 dark:text-green-500'],
                            'Customer' => ['bg' => 'bg-purple-600', 'text' => 'text-purple-600 dark:text-purple-500'],
                            'Division' => ['bg' => 'bg-orange-600', 'text' => 'text-orange-600 dark:text-orange-500'],
                            'WorkType' => ['bg' => 'bg-red-600', 'text' => 'text-red-600 dark:text-red-500'],
                            'WorkOrderIndexing' => [
                                'bg' => 'bg-indigo-600',
                                'text' => 'text-indigo-600 dark:text-indigo-500',
                            ],
                        ];

                        $colorConfig = $colors[$modelName] ?? [
                            'bg' => 'bg-gray-600',
                            'text' => 'text-gray-600 dark:text-gray-500',
                        ];
                    @endphp

                    <div
                        class="group flex flex-col h-full bg-white border border-gray-200 shadow-2xs rounded-xl hover:shadow-lg transition-all duration-300 dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70">
                        <a href="{{ route('admin.recycle-bin.index', ['model' => $modelName]) }}"
                            class="flex flex-col h-full">
                            <div
                                class="h-32 flex flex-col justify-center items-center {{ $colorConfig['bg'] }} rounded-t-xl">
                                <div class="p-3 rounded-lg bg-white/20 backdrop-blur-sm">
                                    <svg class="size-8 text-white" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        @if ($modelName === 'WorkOrder')
                                            <path
                                                d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                            <polyline points="14 2 14 8 20 8" />
                                            <line x1="16" x2="8" y1="13" y2="13" />
                                            <line x1="16" x2="8" y1="17" y2="17" />
                                            <line x1="10" x2="8" y1="9" y2="9" />
                                        @elseif($modelName === 'User')
                                            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        @elseif($modelName === 'Customer')
                                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                            <circle cx="12" cy="7" r="4" />
                                        @elseif($modelName === 'Division')
                                            <rect width="18" height="18" x="3" y="3" rx="2" />
                                            <path d="M8 7v7" />
                                            <path d="M12 7v4" />
                                            <path d="M16 7v9" />
                                        @elseif($modelName === 'WorkType')
                                            <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                                        @else
                                            <path
                                                d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                            <polyline points="14 2 14 8 20 8" />
                                        @endif
                                    </svg>
                                </div>
                            </div>
                            <div class="p-4 md:p-6 flex-1 flex flex-col">
                                <span class="block text-xs font-semibold uppercase {{ $colorConfig['text'] }} mb-1">
                                    {{ $stats['label'] }}
                                </span>
                                <h3 class="text-3xl font-bold text-gray-800 dark:text-neutral-300 mb-2">
                                    {{ $stats['count'] }}
                                </h3>
                                <p class="mt-auto text-sm text-gray-500 dark:text-neutral-500">
                                    Click to view details
                                </p>
                            </div>
                        </a>
                    </div>
                @empty
                    <!-- Empty State -->
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <svg class="mx-auto size-12 text-gray-400 mb-4" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <path
                                    d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-600 dark:text-neutral-400">Recycle Bin is empty</h3>
                            <p class="text-sm text-gray-500 dark:text-neutral-500 mt-1">No items have been deleted yet</p>
                        </div>
                    </div>
                @endforelse
            </div>
        @else
            <!-- Back Button and Filtered Items -->
            <div class="mb-6">
                <a href="{{ route('admin.recycle-bin.index') }}"
                    class="inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 py-2 px-3">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="m6 9 6-6 6 6" />
                        <path d="M12 3v14" />
                    </svg>
                    Back to Overview
                </a>
            </div>

            <!-- Table Card -->
            <div class="bg-white rounded-xl shadow-2xs border border-gray-200 dark:bg-neutral-900 dark:border-neutral-700">
                <!-- Table -->
                <div class="flex flex-col">
                    <div class="-m-1.5 overflow-x-auto">
                        <div class="p-1.5 min-w-full inline-block align-middle">
                            <div class="overflow-hidden">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                                ID</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                                Information</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                                Deleted At</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                                Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                        @forelse($trashedItems as $item)
                                            <tr
                                                class="hover:bg-gray-50 dark:hover:bg-neutral-800 transition-all duration-200">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-800 dark:text-neutral-200">
                                                    {{ $item->id }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200">
                                                    @if (method_exists($item, 'name'))
                                                        <div class="font-medium">{{ $item->name ?? '-' }}</div>
                                                    @elseif(method_exists($item, 'ref_id'))
                                                        <div class="font-medium">
                                                            {{ $item->ref_id ?? 'Work Order #' . $item->id }}</div>
                                                    @else
                                                        <div class="font-medium">{{ class_basename($item) }}
                                                            #{{ $item->id }}</div>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-neutral-400">
                                                    {{ $item->deleted_at->format('Y-m-d H:i:s') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                    <div class="flex justify-end gap-x-2">
                                                        <button type="button"
                                                            onclick="restoreItem('{{ $modelType }}', {{ $item->id }})"
                                                            class="inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-green-600 hover:text-green-800 focus:outline-hidden focus:text-green-800 disabled:opacity-50 disabled:pointer-events-none dark:text-green-500 dark:hover:text-green-400 dark:focus:text-green-400 py-1 px-2">
                                                            <svg class="shrink-0 size-4"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M3 7v6h6" />
                                                                <path d="M21 17a9 9 0 0 0-9-9 9 9 0 0 0-6 2.3L3 13" />
                                                            </svg>
                                                            Restore
                                                        </button>
                                                        <button type="button"
                                                            onclick="deleteItem('{{ $modelType }}', {{ $item->id }})"
                                                            class="inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent text-red-600 hover:text-red-800 focus:outline-hidden focus:text-red-800 disabled:opacity-50 disabled:pointer-events-none dark:text-red-500 dark:hover:text-red-400 dark:focus:text-red-400 py-1 px-2">
                                                            <svg class="shrink-0 size-4"
                                                                xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round">
                                                                <path d="M3 6h18" />
                                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                                                            </svg>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-12 text-center">
                                                    <div
                                                        class="flex flex-col items-center justify-center text-gray-400 dark:text-neutral-500">
                                                        <svg class="shrink-0 size-12 mb-3"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <path
                                                                d="M20 13V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7m16 0v5a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-5m16 0h-2.586a1 1 0 0 0-.707.293l-2.414 2.414a1 1 0 0 1-.707.293h-3.172a1 1 0 0 1-.707-.293l-2.414-2.414A1 1 0 0 0 6.586 13H4" />
                                                        </svg>
                                                        <p class="text-lg font-medium text-gray-600 dark:text-neutral-400">
                                                            No items found</p>
                                                        <p class="text-sm">No items in recycle bin for this category</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Table -->

                <!-- Pagination -->
                @if ($trashedItems instanceof \Illuminate\Pagination\Paginator)
                    <div class="px-6 py-4 border-t border-gray-200 dark:border-neutral-700">
                        {{ $trashedItems->links() }}
                    </div>
                @endif
            </div>
            <!-- End Card -->

            <!-- Empty Bin Button -->
            @if (
                $trashedItems instanceof \Illuminate\Database\Eloquent\Collection
                    ? $trashedItems->count()
                    : $trashedItems->total() > 0)
                <div class="mt-6 flex justify-center">
                    <button type="button" onclick="emptyBin()"
                        class="inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-hidden focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none py-2 px-3">
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18" />
                            <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6" />
                            <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2" />
                        </svg>
                        Empty Recycle Bin
                    </button>
                </div>
            @endif
        @endif
    </div>
    <!-- End Card Section -->

    <!-- Scripts -->
    <script>
        const restoreItem = async (modelType, modelId) => {
            const result = await Swal.fire({
                title: 'Restore Item?',
                text: 'Are you sure you want to restore this item?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, restore it!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#6b7280',
                reverseButtons: true
            });

            if (!result.isConfirmed) {
                return;
            }

            try {
                const response = await fetch('{{ route('admin.recycle-bin.restore') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        model_type: modelType,
                        model_id: modelId
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    await Swal.fire({
                        title: 'Restored!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    });
                    location.reload();
                } else {
                    await Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (error) {
                await Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        };

        const deleteItem = async (modelType, modelId) => {
            const result = await Swal.fire({
                title: 'Permanent Delete?',
                text: 'This will permanently delete this item and cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete permanently!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                dangerMode: true
            });

            if (!result.isConfirmed) {
                return;
            }

            try {
                const response = await fetch('{{ route('admin.recycle-bin.force-delete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        model_type: modelType,
                        model_id: modelId
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    await Swal.fire({
                        title: 'Permanently Deleted!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    });
                    location.reload();
                } else {
                    await Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (error) {
                await Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        };

        const emptyBin = async () => {
            const result = await Swal.fire({
                title: 'Empty Recycle Bin?',
                text: 'This will permanently delete ALL items in the recycle bin. This action cannot be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, empty everything!',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                reverseButtons: true,
                dangerMode: true,
                customClass: {
                    confirmButton: 'swal2-confirm-delete'
                }
            });

            if (!result.isConfirmed) {
                return;
            }

            try {
                const response = await fetch('{{ route('admin.recycle-bin.empty') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                });

                const data = await response.json();

                if (response.ok) {
                    await Swal.fire({
                        title: 'Recycle Bin Emptied!',
                        text: data.message,
                        icon: 'success',
                        confirmButtonColor: '#10b981'
                    });
                    location.reload();
                } else {
                    await Swal.fire({
                        title: 'Error!',
                        text: data.message,
                        icon: 'error',
                        confirmButtonColor: '#ef4444'
                    });
                }
            } catch (error) {
                await Swal.fire({
                    title: 'Error!',
                    text: 'An error occurred: ' + error.message,
                    icon: 'error',
                    confirmButtonColor: '#ef4444'
                });
            }
        };
    </script>
@endsection
