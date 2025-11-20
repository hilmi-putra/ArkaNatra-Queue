@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 dark:bg-neutral-800">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Profile
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage your name, password and account settings.
                </p>
            </div>

            <!-- Profile Information -->
            <div class="grid sm:grid-cols-12 gap-2 sm:gap-6 mb-8">

                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                        Full name
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <p class="text-gray-800 dark:text-neutral-200">{{ $user->name }}</p>
                </div>

                <div class="sm:col-span-3">
                    <label class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                        Email
                    </label>
                </div>

                <div class="sm:col-span-9">
                    <p class="text-gray-800 dark:text-neutral-200">{{ $user->email }}</p>
                </div>

                <div class="sm:col-span-9">
                    <p class="text-gray-800 dark:text-neutral-200 capitalize">{{ $user->role }}</p>
                </div>
            </div>

            <div class="flex justify-end gap-x-2">
                <a href="{{ route('profile.edit') }}"
                    class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                    Edit Profile
                </a>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Card Section -->
@endsection
