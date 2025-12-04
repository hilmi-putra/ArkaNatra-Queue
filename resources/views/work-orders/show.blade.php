@extends('layouts.app')

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Detail Work Order</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Informasi lengkap work order dan data terkait</p>
                </div>
                <div class="flex gap-2">
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

                    @hasanyrole('asservice|production')
                        <a href="{{ route($prefix . 'work-orders.edit', $workOrder->id) }}"
                            class="inline-flex items-center gap-x-2.5 py-2.5 px-4 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md">
                            <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>
                            Edit
                        </a>
                    @endhasanyrole

                    <a href="{{ route($prefix . 'work-orders.index') }}"
                        class="inline-flex items-center gap-x-2.5 py-2.5 px-4 text-sm font-semibold rounded-lg border border-gray-200 bg-white text-gray-700 hover:bg-gray-50 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-100 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-700 dark:hover:border-neutral-600">
                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                        </svg>
                        Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Kolom Kiri - Informasi Utama -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Card: Informasi Work Order -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Work Order</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Ref
                                    ID</label>
                                <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $workOrder->ref_id }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                @php
                                    $statusMap = [
                                        'validate' => [
                                            'class' =>
                                                'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                            'text' => 'Validasi',
                                        ],
                                        'pending' => [
                                            'class' =>
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                            'text' => 'Pending',
                                        ],
                                        'completed' => [
                                            'class' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                            'text' => 'Selesai',
                                        ],
                                        'revision' => [
                                            'class' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                            'text' => 'Revisi',
                                        ],
                                        'in_progress' => [
                                            'class' =>
                                                'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300',
                                            'text' => 'Dalam Proses',
                                        ],
                                    ];
                                    $statusInfo = $statusMap[$workOrder->status] ?? [
                                        'class' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                        'text' => $workOrder->status,
                                    ];
                                @endphp
                                <span
                                    class="inline-flex items-center gap-x-1.5 py-1.5 px-3 rounded-full text-xs font-medium {{ $statusInfo['class'] }}">
                                    {{ $statusInfo['text'] }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nomor
                                    Antrian</label>
                                <p class="text-2xl font-bold text-orange-600 dark:text-orange-400">
                                    #{{ $workOrder->antrian_ke }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Estimasi
                                    Selesai</label>
                                <p class="text-sm text-gray-900 dark:text-white">
                                    {{ $workOrder->estimasi_date ?? '-' }}
                                </p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Divisi</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->division->name ?? '-' }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Jenis
                                    Pekerjaan</label>
                                <p class="text-sm text-gray-900 dark:text-white">
                                    {{ $workOrder->workType->work_type ?? '-' }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Domain</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->domain ?? '-' }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Quantity</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->quantity }}</p>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Deskripsi
                                Pekerjaan</label>
                            <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4">
                                <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">
                                    {{ $workOrder->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Data Customer -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Data Customer</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nama
                                    Customer</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->customer->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Email</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->customer->email }}</p>
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Telepon</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->customer->phone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Token</label>
                                <p class="text-sm font-mono text-gray-900 dark:text-white">
                                    {{ $workOrder->customer->token }}</p>
                            </div>
                            <div class="md:col-span-2">
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Alamat</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->customer->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card: Data Akses -->
                @if ($workOrder->customer->accessCredentials && $workOrder->customer->accessCredentials->count() > 0)
                    <div
                        class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                        <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Data Akses</h2>

                            <!-- Action Buttons -->
                            @if ($workOrder->status === 'finish')
                                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                                    <!-- Send Access Button -->
                                    <button type="button"
                                        class="py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                        data-hs-overlay="#hs-send-access-modal" data-workorder-id="{{ $workOrder->id }}"
                                        data-credential-web="{{ $workOrder->accessCredential->access_web ?? null }}"
                                        data-credential-ojs="{{ $workOrder->accessCredential->akses_ojs ?? null }}"
                                        data-credential-cpanel="{{ $workOrder->accessCredential->akses_cpanel ?? null }}"
                                        data-credential-webmail="{{ $workOrder->accessCredential->akses_webmail ?? null }}"
                                        {{ $workOrder->send_access ? 'disabled' : '' }}>
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m22 2-7 20-4-9-9-4Z" />
                                            <path d="M22 2 11 13" />
                                        </svg>
                                        {{ $workOrder->send_access ? 'Akses Terkirim' : 'Kirim Akses' }}
                                    </button>

                                    <!-- Send to Email Button -->
                                    <button type="button"
                                        class="send-email-btn py-2.5 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-white dark:hover:bg-neutral-700"
                                        data-hs-overlay="#hs-send-email-modal" data-workorder-id="{{ $workOrder->id }}"
                                        {{ !$workOrder->send_access ? 'disabled' : '' }}>
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <rect width="20" height="16" x="2" y="4" rx="2" />
                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                                        </svg>
                                        Kirim ke Email
                                    </button>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 space-y-4">
                            @foreach ($workOrder->customer->accessCredentials as $credential)
                                @if ($credential->akses_ojs)
                                    <div class="border border-gray-200 rounded-lg p-4 dark:border-neutral-700">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-md font-semibold text-gray-900 dark:text-white">OJS</h4>
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">OJS</span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">URL</label>
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ $credential->akses_ojs }}" target="_blank"
                                                        class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 truncate flex-1">
                                                        {{ $credential->akses_ojs }}
                                                    </a>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->akses_ojs }}" title="Copy URL">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Username</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->username_ojs }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->username_ojs }}"
                                                        title="Copy Username">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Password</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->password_ojs }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->password_ojs }}"
                                                        title="Copy Password">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($credential->akses_cpanel)
                                    <div class="border border-gray-200 rounded-lg p-4 dark:border-neutral-700">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-md font-semibold text-gray-900 dark:text-white">cPanel</h4>
                                            <span
                                                class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">cPanel</span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">URL</label>
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ $credential->akses_cpanel }}" target="_blank"
                                                        class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 truncate flex-1">
                                                        {{ $credential->akses_cpanel }}
                                                    </a>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->akses_cpanel }}"
                                                        title="Copy URL">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Username</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->username_cpanel }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->username_cpanel }}"
                                                        title="Copy Username">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Password</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->password_cpanel }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->password_cpanel }}"
                                                        title="Copy Password">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($credential->akses_webmail)
                                    <div class="border border-gray-200 rounded-lg p-4 dark:border-neutral-700">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-md font-semibold text-gray-900 dark:text-white">Webmail</h4>
                                            <span
                                                class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">Webmail</span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">URL</label>
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ $credential->akses_webmail }}" target="_blank"
                                                        class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 truncate flex-1">
                                                        {{ $credential->akses_webmail }}
                                                    </a>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->akses_webmail }}"
                                                        title="Copy URL">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Username</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->username_webmail }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->username_webmail }}"
                                                        title="Copy Username">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Password</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->password_webmail }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->password_webmail }}"
                                                        title="Copy Password">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($credential->access_web)
                                    <div class="border border-gray-200 rounded-lg p-4 dark:border-neutral-700">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="text-md font-semibold text-gray-900 dark:text-white">Website</h4>
                                            <span
                                                class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-orange-900 dark:text-orange-300">Website</span>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">URL</label>
                                                <div class="flex items-center gap-2">
                                                    <a href="{{ $credential->access_web }}" target="_blank"
                                                        class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 truncate flex-1">
                                                        {{ $credential->access_web }}
                                                    </a>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->access_web }}" title="Copy URL">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Username</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->username_web }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->username_web }}"
                                                        title="Copy Username">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            <div>
                                                <label
                                                    class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Password</label>
                                                <div class="flex items-center gap-2">
                                                    <p class="text-sm text-gray-900 dark:text-white truncate flex-1">
                                                        {{ $credential->password_web }}</p>
                                                    <button type="button"
                                                        class="copy-btn shrink-0 p-1 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                                        data-copy-text="{{ $credential->password_web }}"
                                                        title="Copy Password">
                                                        <svg class="size-4" xmlns="http://www.w3.org/2000/svg"
                                                            width="16" height="16" fill="currentColor"
                                                            viewBox="0 0 16 16">
                                                            <path
                                                                d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z" />
                                                            <path
                                                                d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            <div class="bg-gray-50 dark:bg-neutral-700 rounded-lg p-4">
                                <label
                                    class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Catatan</label>
                                <p class="text-sm text-gray-900 dark:text-white">{{ $credential->note }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Kolom Kanan - Informasi Tambahan -->
            <div class="space-y-6">
                <!-- Card: Timeline -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Timeline</h2>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <!-- Timeline 1: Diterima -->
                            <div class="flex gap-3">
                                <div class="shrink-0 size-2 bg-blue-600 rounded-full mt-2"></div>
                                <div class="grow">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Diterima</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $workOrder->date_received ?? '-' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Timeline 2: Masuk Antrian -->
                            @if ($workOrder->date_queue)
                                <div class="flex gap-3">
                                    <div class="shrink-0 size-2 bg-green-600 rounded-full mt-2"></div>
                                    <div class="grow">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Masuk Antrian</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $workOrder->date_queue }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Timeline 3: revision -->
                            @if ($workOrder->date_revision)
                                <div class="flex gap-3">
                                    <div class="shrink-0 size-2 bg-orange-600 rounded-full mt-2"></div>
                                    <div class="grow">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">revision</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $workOrder->date_revision }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Timeline 3: Migration -->
                            @if ($workOrder->date_migration)
                                <div class="flex gap-3">
                                    <div class="shrink-0 size-2 bg-purple-600 rounded-full mt-2"></div>
                                    <div class="grow">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Migration</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $workOrder->date_migration }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Timeline 4: Selesai -->
                            @if ($workOrder->date_completed)
                                <div class="flex gap-3">
                                    <div class="shrink-0 size-2 bg-gray-600 rounded-full mt-2"></div>
                                    <div class="grow">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Selesai</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $workOrder->date_completed }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <!-- Timeline 4: Selesai -->
                            @if ($workOrder->date_cancelled)
                                <div class="flex gap-3">
                                    <div class="shrink-0 size-2 bg-red-600 rounded-full mt-2"></div>
                                    <div class="grow">
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">Dibatalkan</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $workOrder->date_cancelled }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card: Work Order Indexing -->
                @php
                    $workOrderIndexing = $workOrder->workOrderIndexing()->with('indexingType')->get();
                @endphp
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Kategori Indexing</h2>
                    </div>
                    <div class="p-6">
                        @if ($workOrderIndexing->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach ($workOrderIndexing as $indexing)
                                    <div
                                        class="inline-flex items-center gap-2 px-4 py-2 bg-green-100 text-green-800 rounded-full dark:bg-green-900 dark:text-green-300 border border-green-200 dark:border-green-700">
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16"
                                            height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path
                                                d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium">{{ $indexing->indexingType->indexing_name }}</span>
                                    </div>
                                @endforeach
                            </div>
                            @if ($workOrderIndexing->first()->description)
                                <div class="mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Deskripsi:</p>
                                    <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">
                                        {{ $workOrderIndexing->first()->indexingType->description }}
                                    </p>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-6">
                                <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada kategori indexing yang
                                    dipilih</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card: File Upload -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">File Terlampir</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        @if ($workOrder->file_mou)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-neutral-700">
                                <div class="flex items-center gap-3">
                                    <svg class="shrink-0 size-8 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">File MOU</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF Document</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($workOrder->file_mou) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" x2="12" y1="15" y2="3" />
                                    </svg>
                                </a>
                            </div>
                        @endif

                        @if ($workOrder->file_work_form)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-neutral-700">
                                <div class="flex items-center gap-3">
                                    <svg class="shrink-0 size-8 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">File Work Form</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PDF Document</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($workOrder->file_work_form) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" x2="12" y1="15" y2="3" />
                                    </svg>
                                </a>
                            </div>
                        @endif

                        @if ($workOrder->additional_file)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg dark:bg-neutral-700">
                                <div class="flex items-center gap-3">
                                    <svg class="shrink-0 size-8 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">File Tambahan</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Additional File</p>
                                    </div>
                                </div>
                                <a href="{{ Storage::url($workOrder->additional_file) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400">
                                    <svg class="size-5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4" />
                                        <polyline points="7 10 12 15 17 10" />
                                        <line x1="12" x2="12" y1="15" y2="3" />
                                    </svg>
                                </a>
                            </div>
                        @endif

                        @if (!$workOrder->file_mou && !$workOrder->file_work_form && !$workOrder->additional_file)
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Tidak ada file terlampir
                            </p>
                        @endif
                    </div>
                </div>

                <!-- Card: Informasi Teknis -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-2xs dark:bg-neutral-800 dark:border-neutral-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informasi Teknis</h2>
                    </div>
                    <div class="p-6 space-y-3">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Marketing</label>
                            <p class="text-sm text-gray-900 dark:text-white">{{ $workOrder->salesUser->name ?? 'System' }}
                            </p>
                        </div>
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Production</label>
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $workOrder->productionUser->name ?? 'System' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tanggal
                                Dibuat</label>
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $workOrder->created_at ?? '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Terakhir
                                Diupdate</label>
                            <p class="text-sm text-gray-900 dark:text-white">
                                {{ $workOrder->updated_at ?? '-' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

<!-- JavaScript untuk Copy Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Copy button functionality
        const copyButtons = document.querySelectorAll('.copy-btn');

        copyButtons.forEach(button => {
            button.addEventListener('click', function() {
                const textToCopy = this.getAttribute('data-copy-text');

                // Copy ke clipboard
                navigator.clipboard.writeText(textToCopy).then(() => {
                    // Ubah icon sementara menjadi checkmark
                    const originalHTML = this.innerHTML;
                    this.innerHTML = `
                    <svg class="size-4 text-green-500" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M10.97 4.97a.75.75 0 0 1 1.07 1.05l-3.99 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.267.267 0 0 1 .02-.022z"/>
                    </svg>
                `;

                    // Kembalikan icon setelah 2 detik
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                    }, 2000);

                    showToast('Teks berhasil disalin!');
                }).catch(err => {
                    console.error('Gagal menyalin teks: ', err);
                    showToast('Gagal menyalin teks', 'error');
                });
            });
        });
    });
</script>
