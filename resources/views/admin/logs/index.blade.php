@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Activity Logs</h1>
            <p class="text-lg text-gray-600 dark:text-neutral-400">Track and monitor all system activities and user actions
            </p>
        </div>

        <!-- Filter Card -->
        <div class="bg-white rounded-xl shadow-2xs border border-gray-200 dark:bg-neutral-900 dark:border-neutral-700 mb-6">
            <div class="p-6">
                <form method="GET" action="{{ route('admin.logs.index') }}">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                        <!-- Activity Type Filter -->
                        <div>
                            <label for="activity_type" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                                Activity Type
                            </label>
                            <select name="activity_type" id="activity_type"
                                class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option value="">All Activities</option>
                                @foreach ($activityTypes as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ request('activity_type') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Model Type Filter -->
                        <div>
                            <label for="model_type" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                                Model Type
                            </label>
                            <select name="model_type" id="model_type"
                                class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option value="">All Models</option>
                                @foreach ($modelTypes as $key => $label)
                                    <option value="{{ $key }}"
                                        {{ request('model_type') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- User Filter -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                                User
                            </label>
                            <select name="user_id" id="user_id"
                                class="py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <option value="">All Users</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                                Search Description
                            </label>
                            <div class="relative">
                                <input type="text" name="search" id="search" placeholder="Search..."
                                    value="{{ request('search') }}"
                                    class="py-2 px-3 ps-11 block w-full border-gray-200 shadow-2xs rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                                <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-4">
                                    <svg class="shrink-0 size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <!-- Date From -->
                        <div>
                            <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                                From Date
                            </label>
                            <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                class="py-2 px-3 block w-full border-gray-200 shadow-2xs rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-white mb-2">
                                To Date
                            </label>
                            <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                class="py-2 px-3 block w-full border-gray-200 shadow-2xs rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <button type="submit"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                            Apply Filters
                        </button>
                        <a href="{{ route('admin.logs.index') }}"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700 dark:focus:bg-neutral-700">
                            Reset Filters
                        </a>
                        <a href="{{ route('admin.logs.export') }}?{{ http_build_query(request()->all()) }}"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                <polyline points="7 10 12 15 17 10" />
                                <line x1="12" x2="12" y1="15" y2="3" />
                            </svg>
                            Export CSV
                        </a>
                    </div>
                </form>
            </div>
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
                                            Date & Time</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            User</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Activity</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Model</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Description</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            IP Address</th>
                                        <th scope="col"
                                            class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-400">
                                            Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                                    @forelse($logs as $log)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-neutral-800 transition-all duration-200">
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                {{ $log->user ? $log->user->name : 'System' }}
                                            </td>
                                            {{-- Di dalam tabel --}}
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $activityConfig = [
                                                        'created' => [
                                                            'label' => 'Created',
                                                            'color' => 'hsla(142, 76%, 36%, 1)',
                                                            'bgColor' => 'hsla(142, 76%, 96%, 1)',
                                                            'icon' =>
                                                                '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/></svg>',
                                                        ],
                                                        'updated' => [
                                                            'label' => 'Updated',
                                                            'color' => 'hsla(221, 83%, 53%, 1)',
                                                            'bgColor' => 'hsla(221, 83%, 96%, 1)',
                                                            'icon' =>
                                                                '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z" clip-rule="evenodd"/></svg>',
                                                        ],
                                                        'deleted' => [
                                                            'label' => 'Deleted',
                                                            'color' => 'hsla(0, 84%, 60%, 1)',
                                                            'bgColor' => 'hsla(0, 84%, 96%, 1)',
                                                            'icon' =>
                                                                '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z" clip-rule="evenodd"/></svg>',
                                                        ],
                                                        'restored' => [
                                                            'label' => 'Restored',
                                                            'color' => 'hsla(162, 93%, 23%, 1)',
                                                            'bgColor' => 'hsla(162, 93%, 96%, 1)',
                                                            'icon' =>
                                                                '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M15.312 11.424a5.5 5.5 0 01-9.201 2.466l-.312-.311h2.433a.75.75 0 000-1.5H3.989a.75.75 0 00-.75.75v4.242a.75.75 0 001.5 0v-2.43l.31.31a7 7 0 0011.712-3.138.75.75 0 00-1.449-.39zm1.23-3.723a.75.75 0 00.219-.53V2.929a.75.75 0 00-1.5 0V5.36l-.31-.31A7 7 0 003.239 8.188a.75.75 0 101.448.389A5.5 5.5 0 0113.89 6.11l.311.31h-2.432a.75.75 0 000 1.5h4.243a.75.75 0 00.53-.219z" clip-rule="evenodd"/></svg>',
                                                        ],
                                                        'login' => [
                                                            'label' => 'Login',
                                                            'color' => 'hsla(271, 91%, 65%, 1)',
                                                            'bgColor' => 'hsla(271, 91%, 96%, 1)',
                                                            'icon' =>
                                                                '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M19 10a.75.75 0 00-.75-.75H8.704l1.048-.943a.75.75 0 10-1.004-1.114l-2.5 2.25a.75.75 0 000 1.114l2.5 2.25a.75.75 0 101.004-1.114l-1.048-.943h9.546A.75.75 0 0019 10z" clip-rule="evenodd"/></svg>',
                                                        ],
                                                        'logout' => [
                                                            'label' => 'Logout',
                                                            'color' => 'hsla(290, 91%, 43%, 1)',
                                                            'bgColor' => 'hsla(290, 91%, 96%, 1)',
                                                            'icon' =>
                                                                '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4.25A2.25 2.25 0 015.25 2h5.5A2.25 2.25 0 0113 4.25v2a.75.75 0 01-1.5 0v-2a.75.75 0 00-.75-.75h-5.5a.75.75 0 00-.75.75v11.5c0 .414.336.75.75.75h5.5a.75.75 0 00.75-.75v-2a.75.75 0 011.5 0v2A2.25 2.25 0 0110.75 18h-5.5A2.25 2.25 0 013 15.75V4.25z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M6 10a.75.75 0 01.75-.75h9.546l-1.048-.943a.75.75 0 111.004-1.114l2.5 2.25a.75.75 0 010 1.114l-2.5 2.25a.75.75 0 11-1.004-1.114l1.048-.943H6.75A.75.75 0 016 10z" clip-rule="evenodd"/></svg>',
                                                        ],
                                                        'status_changed' => [
                                                            'label' => 'Status Changed',
                                                            'color' => 'hsla(32, 95%, 44%, 1)',
                                                            'bgColor' => 'hsla(32, 95%, 96%, 1)',
                                                            'icon' =>
                                                                '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 01.26.77 7 7 0 009.958 7.967.75.75 0 011.067.853A8.5 8.5 0 116.647 1.921a.75.75 0 01.808.083z" clip-rule="evenodd"/></svg>',
                                                        ],
                                                    ];

                                                    $config = $activityConfig[$log->activity_type] ?? [
                                                        'label' => $log->getActivityTypeLabel(),
                                                        'color' => 'hsla(215, 16%, 47%, 1)',
                                                        'bgColor' => 'hsla(215, 16%, 96%, 1)',
                                                        'icon' =>
                                                            '<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-13a.75.75 0 00-1.5 0v5c0 .414.336.75.75.75h4a.75.75 0 000-1.5h-3.25V5z" clip-rule="evenodd"/></svg>',
                                                    ];
                                                @endphp

                                                <div class="inline-flex items-center gap-x-1.5 py-1 px-3 rounded-full text-xs font-medium"
                                                    style="color: {{ $config['color'] }}; background-color: {{ $config['bgColor'] }}">
                                                    {!! $config['icon'] !!}
                                                    {{ $config['label'] }}
                                                </div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">
                                                {{ $log->getModelTypeLabel() }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-800 dark:text-neutral-200 max-w-xs">
                                                <div class="truncate" title="{{ $log->description }}">
                                                    {{ $log->description }}</div>
                                            </td>
                                            <td
                                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-neutral-400">
                                                {{ $log->ip_address ?? '-' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                                <a href="{{ route('admin.logs.show', $log) }}"
                                                    class="inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-blue-600 hover:text-blue-800 focus:outline-hidden focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:text-blue-400 dark:focus:text-blue-400">
                                                    View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="px-6 py-12 text-center">
                                                <div
                                                    class="flex flex-col items-center justify-center text-gray-400 dark:text-neutral-500">
                                                    <svg class="shrink-0 size-12 mb-3" xmlns="http://www.w3.org/2000/svg"
                                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                        stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path
                                                            d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                                        <polyline points="14 2 14 8 20 8" />
                                                        <line x1="16" x2="8" y1="13"
                                                            y2="13" />
                                                        <line x1="16" x2="8" y1="17"
                                                            y2="17" />
                                                        <line x1="10" x2="8" y1="9"
                                                            y2="9" />
                                                    </svg>
                                                    <p class="text-lg font-medium text-gray-600 dark:text-neutral-400">No
                                                        logs found</p>
                                                    <p class="text-sm">Try adjusting your filters to find what you're
                                                        looking for.</p>
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
        </div>
        <!-- End Card -->
    </div>
    <!-- End Card Section -->
@endsection
