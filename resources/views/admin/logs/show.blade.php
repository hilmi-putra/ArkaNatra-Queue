@extends('layouts.app')

@section('content')
    <div class="px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.logs.index') }}"
                class="inline-flex items-center gap-x-2 text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-600 mb-4">
                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 12H5M12 19l-7-7 7-7" />
                </svg>
                Back to Logs
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Activity Log Details</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Details -->
            <div class="lg:col-span-2">
                <div
                    class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Activity Information</h2>
                    </div>

                    <div class="px-6 py-6 space-y-6">
                        <!-- Activity Type & Badge -->
                        <div class="flex items-center gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Activity Type</p>
                                <span
                                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-medium text-white {{ $log->getActivityTypeBadgeColor() }}">
                                    {{ $log->getActivityTypeLabel() }}
                                </span>
                            </div>
                        </div>

                        <!-- Date & Time -->
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Date & Time</p>
                            <p class="text-gray-900 dark:text-white">{{ $log->created_at->format('l, F j, Y \a\t H:i:s') }}
                            </p>
                        </div>

                        <!-- Model Information -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Model Type</p>
                                <p class="text-gray-900 dark:text-white">{{ $log->getModelTypeLabel() }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Model ID</p>
                                <p class="text-gray-900 dark:text-white font-mono">{{ $log->model_id ?? '-' }}</p>
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">Description</p>
                            <p class="text-gray-900 dark:text-white">{{ $log->description }}</p>
                        </div>

                        <!-- IP Address -->
                        <div>
                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400 mb-1">IP Address</p>
                            <p class="text-gray-900 dark:text-white font-mono">{{ $log->ip_address ?? 'Not available' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Old Values -->
                @if ($log->old_values)
                    <div
                        class="mt-6 bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Previous Values</h3>
                        </div>
                        <div class="px-6 py-6">
                            <div class="bg-red-50 dark:bg-red-900/20 rounded-lg p-4 max-h-96 overflow-y-auto">
                                <pre class="text-sm text-gray-700 dark:text-gray-300 font-mono whitespace-pre-wrap break-words">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- New Values -->
                @if ($log->new_values)
                    <div
                        class="mt-6 bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">New Values</h3>
                        </div>
                        <div class="px-6 py-6">
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 max-h-96 overflow-y-auto">
                                <pre class="text-sm text-gray-700 dark:text-gray-300 font-mono whitespace-pre-wrap break-words">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar - User Information -->
            <div class="lg:col-span-1">
                <div
                    class="bg-white dark:bg-neutral-900 rounded-lg shadow-sm border border-gray-200 dark:border-neutral-700 overflow-hidden sticky top-4">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700 bg-gray-50 dark:bg-neutral-800">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Information</h3>
                    </div>

                    <div class="px-6 py-6">
                        @if ($log->user)
                            <div class="space-y-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase mb-1">User Name
                                    </p>
                                    <p class="text-gray-900 dark:text-white font-semibold">{{ $log->user->name }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase mb-1">Email</p>
                                    <p class="text-gray-900 dark:text-white text-sm break-all">{{ $log->user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase mb-1">User ID
                                    </p>
                                    <p class="text-gray-900 dark:text-white font-mono text-sm">{{ $log->user->id }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400 uppercase mb-1">Roles</p>
                                    <div class="flex flex-wrap gap-2">
                                        @forelse($log->user->getRoleNames() as $role)
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded text-xs font-medium text-white bg-indigo-600">
                                                {{ ucfirst($role) }}
                                            </span>
                                        @empty
                                            <span class="text-gray-600 dark:text-gray-400 text-sm">No roles assigned</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-gray-600 dark:text-gray-400 mt-2 text-sm">System Activity</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
