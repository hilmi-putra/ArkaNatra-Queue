@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <!-- Card -->
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 dark:bg-neutral-800">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    Edit Profile
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    Manage your name, password and account settings.
                </p>
            </div>

            <!-- Notifikasi -->
            @if (session('success'))
                <div
                    class="mb-4 bg-green-50 border border-green-200 text-green-600 rounded-lg p-4 dark:bg-green-800/30 dark:border-green-700 dark:text-green-400">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div
                    class="mb-4 bg-red-50 border border-red-200 text-red-600 rounded-lg p-4 dark:bg-red-800/30 dark:border-red-700 dark:text-red-400">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Form Edit Profil -->
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                    <!-- End Col -->

                    <div class="sm:col-span-3">
                        <label for="name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Full name
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('name') border-red-500 @enderror"
                            placeholder="Full name">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-3">
                        <label for="email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Email
                        </label>
                    </div>
                    <!-- End Col -->

                    <div class="sm:col-span-9">
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('email') border-red-500 @enderror"
                            placeholder="Email address">
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- End Col -->

                </div>
                <!-- End Grid -->

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('profile.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Cancel
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Save changes
                    </button>
                </div>
            </form>

            <!-- Form Update Password -->
            <div class="mt-8 pt-8 border-t border-gray-200 dark:border-neutral-700">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mb-4">
                    Change Password
                </h3>

                <form action="{{ route('profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                        <div class="sm:col-span-3">
                            <label for="current_password"
                                class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                Current Password
                            </label>
                        </div>

                        <div class="sm:col-span-9">
                            <input id="current_password" name="current_password" type="password"
                                class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('current_password') border-red-500 @enderror"
                                placeholder="Enter current password">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="new_password"
                                class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                New Password
                            </label>
                        </div>

                        <div class="sm:col-span-9">
                            <input id="new_password" name="new_password" type="password"
                                class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 @error('new_password') border-red-500 @enderror"
                                placeholder="Enter new password">
                            @error('new_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-3">
                            <label for="new_password_confirmation"
                                class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                                Confirm New Password
                            </label>
                        </div>

                        <div class="sm:col-span-9">
                            <input id="new_password_confirmation" name="new_password_confirmation" type="password"
                                class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Confirm new password">
                        </div>
                    </div>

                    <div class="mt-5 flex justify-end gap-x-2">
                        <button type="submit"
                            class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-green-600 text-white hover:bg-green-700 focus:outline-hidden focus:bg-green-700 disabled:opacity-50 disabled:pointer-events-none">
                            Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Card -->
    </div>
    <!-- End Card Section -->
@endsection
