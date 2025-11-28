@extends('layouts.app')

@php
    $role = auth()->user()->getRoleNames()->first();
    $prefix = match ($role) {
        'admin' => 'admin.',
        'production' => 'production.',
        'sales' => 'sales.',
        'asservice' => 'asservice.',
        default => '',
    };
@endphp

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
                                <h2 class="text-xl font-semibold text-gray-800 dark:text-neutral-200">Access Credentials</h2>
                                <p class="text-sm text-gray-600 dark:text-neutral-400">Daftar akses credentials berdasarkan
                                    client.</p>
                            </div>

                            <div class="flex justify-end gap-x-2">
                                <!-- Add New Button -->
                                <a class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                    href="{{ route($prefix . 'access-credentials.create') }}">
                                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M5 12h14" />
                                        <path d="M12 5v14" />
                                    </svg>
                                    Tambah Access Credentials
                                </a>
                            </div>
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
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Customer</span>
                                            </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Web
                                                    Access</span>
                                            </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">OJS</span>
                                            </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">cPanel</span>
                                            </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Webmail</span>
                                            </div>
                                        </th>

                                        <th scope="col" class="px-6 py-3 text-start">
                                            <div class="flex items-center gap-x-2">
                                                <span
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Server</span>
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
                                                    class="text-xs font-semibold uppercase text-gray-800 dark:text-neutral-200">Expiration</span>
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
                                    @foreach ($data as $credential)
                                        <tr class="bg-white hover:bg-gray-50 dark:bg-neutral-900 dark:hover:bg-neutral-800">

                                            <!-- No -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="ps-6 py-3">
                                                    <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                        {{ $loop->iteration }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Customer Name -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3">
                                                    <span class="text-sm font-semibold text-gray-800 dark:text-neutral-200">
                                                        {{ $credential->customer->name ?? '-' }}
                                                    </span>
                                                </div>
                                            </td>

                                            <!-- Web Access -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3 space-y-1">
                                                    @if ($credential->access_web)
                                                        <div class="flex items-center gap-x-2">
                                                            <a href="{{ $credential->access_web }}"
                                                                class="inline-flex items-center gap-x-1 text-sm text-blue-600 hover:text-blue-800 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                                                                target="_blank">
                                                                <svg class="shrink-0 size-4"
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M14 2.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V7.5a.5.5 0 0 0 1 0v-5z" />
                                                                </svg>
                                                                {{ Str::limit(str_replace(['https://', 'http://'], '', $credential->access_web), 20) }}
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if ($credential->username_web)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">{{ $credential->username_web }}</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->username_web }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif

                                                    @if ($credential->password_web)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">••••••••</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->password_web }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- OJS -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3 space-y-1">
                                                    @if ($credential->akses_ojs)
                                                        <div class="flex items-center gap-x-2">
                                                            <a href="{{ $credential->akses_ojs }}"
                                                                class="inline-flex items-center gap-x-1 text-sm text-blue-600 hover:text-blue-800 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                                                                target="_blank">
                                                                <svg class="shrink-0 size-4"
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M14 2.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V7.5a.5.5 0 0 0 1 0v-5z" />
                                                                </svg>
                                                                {{ Str::limit(str_replace(['https://', 'http://'], '', $credential->akses_ojs), 20) }}
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if ($credential->username_ojs)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">{{ $credential->username_ojs }}</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->username_ojs }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif

                                                    @if ($credential->password_ojs)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">••••••••</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->password_ojs }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- cPanel -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3 space-y-1">
                                                    @if ($credential->akses_cpanel)
                                                        <div class="flex items-center gap-x-2">
                                                            <a href="{{ $credential->akses_cpanel }}"
                                                                class="inline-flex items-center gap-x-1 text-sm text-blue-600 hover:text-blue-800 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                                                                target="_blank">
                                                                <svg class="shrink-0 size-4"
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M14 2.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V7.5a.5.5 0 0 0 1 0v-5z" />
                                                                </svg>
                                                                {{ Str::limit(str_replace(['https://', 'http://'], '', $credential->akses_cpanel), 20) }}
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if ($credential->username_cpanel)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">{{ $credential->username_cpanel }}</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->username_cpanel }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif

                                                    @if ($credential->password_cpanel)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">••••••••</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->password_cpanel }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Webmail -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3 space-y-1">
                                                    @if ($credential->akses_webmail)
                                                        <div class="flex items-center gap-x-2">
                                                            <a href="{{ $credential->akses_webmail }}"
                                                                class="inline-flex items-center gap-x-1 text-sm text-blue-600 hover:text-blue-800 hover:underline dark:text-blue-400 dark:hover:text-blue-300"
                                                                target="_blank">
                                                                <svg class="shrink-0 size-4"
                                                                    xmlns="http://www.w3.org/2000/svg" width="16"
                                                                    height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M14 2.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L2.146 13.146a.5.5 0 0 0 .708.708L13 3.707V7.5a.5.5 0 0 0 1 0v-5z" />
                                                                </svg>
                                                                {{ Str::limit(str_replace(['https://', 'http://'], '', $credential->akses_webmail), 20) }}
                                                            </a>
                                                        </div>
                                                    @endif

                                                    @if ($credential->username_webmail)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">{{ $credential->username_webmail }}</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->username_webmail }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif

                                                    @if ($credential->password_webmail)
                                                        <div class="flex items-center gap-x-2">
                                                            <span
                                                                class="text-sm text-gray-600 dark:text-neutral-400">••••••••</span>
                                                            <button type="button"
                                                                class="copy-btn text-gray-400 hover:text-blue-600 dark:text-gray-500 dark:hover:text-blue-400"
                                                                data-text="{{ $credential->password_webmail }}">
                                                                <svg class="size-3.5" xmlns="http://www.w3.org/2000/svg"
                                                                    width="16" height="16" fill="currentColor"
                                                                    viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                                    <path
                                                                        d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Server -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3">
                                                    @if ($credential->server === 'rumahweb')
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full dark:bg-blue-500/10 dark:text-blue-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                            </svg>
                                                            Rumahweb
                                                        </span>
                                                    @elseif($credential->server === 'webhostingallinone')
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-green-100 text-green-800 rounded-full dark:bg-green-500/10 dark:text-green-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                                            </svg>
                                                            Web Hosting All in One
                                                        </span>
                                                    @elseif($credential->server === 'niaga')
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-purple-100 text-purple-800 rounded-full dark:bg-purple-500/10 dark:text-purple-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                            </svg>
                                                            Niaga
                                                        </span>
                                                    @elseif($credential->server === 'nohosting')
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-gray-100 text-gray-800 rounded-full dark:bg-gray-500/10 dark:text-gray-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
                                                            </svg>
                                                            No Hosting
                                                        </span>
                                                    @else
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full dark:bg-yellow-500/10 dark:text-yellow-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                                                            </svg>
                                                            Unknown
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Status -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3">
                                                    @if ($credential->status === 'active')
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-teal-100 text-teal-800 rounded-full dark:bg-teal-500/10 dark:text-teal-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                                            </svg>
                                                            Active
                                                        </span>
                                                    @else
                                                        <span
                                                            class="py-1 px-1.5 inline-flex items-center gap-x-1 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-500/10 dark:text-red-500">
                                                            <svg class="size-2.5" xmlns="http://www.w3.org/2000/svg"
                                                                width="16" height="16" fill="currentColor"
                                                                viewBox="0 0 16 16">
                                                                <path
                                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z" />
                                                            </svg>
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </div>
                                            </td>

                                            <!-- Expiration -->
                                            <td class="size-px whitespace-nowrap">
                                                <div class="px-6 py-3">
                                                    <span class="text-sm text-gray-600 dark:text-neutral-400">
                                                        {{ $credential->expiration_date ? $credential->expiration_date : '-' }}
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
                                                                <!-- Edit -->
                                                                <a href="{{ route($prefix . 'access-credentials.edit', $credential->id) }}"
                                                                    class="flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-blue-600 hover:bg-blue-100 focus:outline-hidden focus:bg-blue-100 dark:text-blue-500 dark:hover:bg-blue-500/10 dark:focus:bg-blue-500/10">
                                                                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                                        width="16" height="16" fill="currentColor"
                                                                        viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zM11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.499 2.499 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5zm-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3zm11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z" />
                                                                    </svg>
                                                                    Edit
                                                                </a>

                                                                @role('admin')
                                                                    <!-- Delete -->
                                                                    <button type="button"
                                                                        class="delete-credential-btn flex items-center gap-x-3 py-2 px-3 rounded-lg text-sm text-red-600 hover:bg-red-100 focus:outline-hidden focus:bg-red-100 dark:text-red-500 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 w-full"
                                                                        data-hs-overlay="#hs-delete-credential-modal"
                                                                        data-credential-id="{{ $credential->id }}"
                                                                        data-credential-customer="{{ $credential->customer->name ?? '-' }}"
                                                                        data-credential-server="{{ $credential->server ?? '-' }}"
                                                                        data-credential-status="{{ $credential->status ?? '-' }}">
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
                                    Tidak ada data credential
                                </h2>
                                <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                                    Mulai dengan menambahkan access credential baru untuk client.
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Copy to clipboard functionality
            document.querySelectorAll('.copy-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const text = this.getAttribute('data-text');
                    navigator.clipboard.writeText(text).then(() => {
                        // Optional: Show success feedback
                        const originalHTML = this.innerHTML;
                        this.innerHTML = `
                    <svg class="size-3.5 text-green-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                    </svg>
                `;
                        setTimeout(() => {
                            this.innerHTML = originalHTML;
                        }, 2000);
                    });
                });
            });
        });
    </script>



@endsection
