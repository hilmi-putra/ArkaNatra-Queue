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
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 dark:bg-neutral-800">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ isset($accessCredential) ? 'Edit Access Credential' : 'Tambah Access Credential Baru' }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ isset($accessCredential) ? 'Update informasi access credential' : 'Buat access credential baru ke dalam sistem' }}
                </p>
            </div>

            <form
                action="{{ isset($accessCredential) ? route($prefix . 'access-credentials.update', $accessCredential->id) : route($prefix . 'access-credentials.store') }}"
                method="POST">
                @csrf
                @if (isset($accessCredential))
                    @method('PUT')
                @endif

                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                    <!-- Customer Selection -->
                    <div class="sm:col-span-3">
                        <label for="customer_id" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Customer *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="customer_id" name="customer_id"
                            class="py-1.5 sm:py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="">Pilih Customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}"
                                    {{ old('customer_id', $accessCredential->customer_id ?? '') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Server Selection -->
                    <div class="sm:col-span-3">
                        <label for="server" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Server
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="server" name="server"
                            class="py-1.5 sm:py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <option value="">Pilih Server</option>
                            <option value="rumahweb"
                                {{ old('server', $accessCredential->server ?? '') == 'rumahweb' ? 'selected' : '' }}>
                                Rumahweb</option>
                            <option value="webhostingallinone"
                                {{ old('server', $accessCredential->server ?? '') == 'webhostingallinone' ? 'selected' : '' }}>
                                Web Hosting All in One</option>
                            <option value="niaga"
                                {{ old('server', $accessCredential->server ?? '') == 'niaga' ? 'selected' : '' }}>Niaga
                            </option>
                            <option value="nohosting"
                                {{ old('server', $accessCredential->server ?? '') == 'nohosting' ? 'selected' : '' }}>No
                                Hosting</option>
                        </select>
                        @error('server')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Selection -->
                    <div class="sm:col-span-3">
                        <label for="status" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Status
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="status" name="status"
                            class="py-1.5 sm:py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <option value="">Pilih Status</option>
                            <option value="active"
                                {{ old('status', $accessCredential->status ?? '') == 'active' ? 'selected' : '' }}>Active
                            </option>
                            <option value="inactive"
                                {{ old('status', $accessCredential->status ?? '') == 'inactive' ? 'selected' : '' }}>
                                Inactive</option>
                        </select>
                        @error('status')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Expiration Date -->
                    <div class="sm:col-span-3">
                        <label for="expiration_date"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Tanggal Expirasi
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="expiration_date" name="expiration_date" type="date"
                            value="{{ old('expiration_date', $accessCredential->expiration_date ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                        @error('expiration_date')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Web Access Section -->
                    <div class="sm:col-span-12">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mt-6 mb-4">
                            Web Access
                        </h3>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="access_web" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Link Akses
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="access_web" name="access_web" type="text"
                            value="{{ old('access_web', $accessCredential->access_web ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="https://...">
                        @error('access_web')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="username_web" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Username
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="username_web" name="username_web" type="text"
                            value="{{ old('username_web', $accessCredential->username_web ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Username">
                        @error('username_web')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="password_web" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Password
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="password_web" name="password_web" type="password"
                            value="{{ old('password_web', $accessCredential->password_web ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Password">
                        @error('password_web')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- OJS Section -->
                    <div class="sm:col-span-12">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mt-6 mb-4">
                            OJS
                        </h3>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="akses_ojs" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Link Akses
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="akses_ojs" name="akses_ojs" type="text"
                            value="{{ old('akses_ojs', $accessCredential->akses_ojs ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="https://...">
                        @error('akses_ojs')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="username_ojs" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Username
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="username_ojs" name="username_ojs" type="text"
                            value="{{ old('username_ojs', $accessCredential->username_ojs ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Username">
                        @error('username_ojs')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="password_ojs" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Password
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="password_ojs" name="password_ojs" type="password"
                            value="{{ old('password_ojs', $accessCredential->password_ojs ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Password">
                        @error('password_ojs')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- cPanel Section -->
                    <div class="sm:col-span-12">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mt-6 mb-4">
                            cPanel
                        </h3>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="akses_cpanel" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Link Akses
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="akses_cpanel" name="akses_cpanel" type="text"
                            value="{{ old('akses_cpanel', $accessCredential->akses_cpanel ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="https://...">
                        @error('akses_cpanel')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="username_cpanel"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Username
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="username_cpanel" name="username_cpanel" type="text"
                            value="{{ old('username_cpanel', $accessCredential->username_cpanel ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Username">
                        @error('username_cpanel')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="password_cpanel"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Password
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="password_cpanel" name="password_cpanel" type="password"
                            value="{{ old('password_cpanel', $accessCredential->password_cpanel ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Password">
                        @error('password_cpanel')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Webmail Section -->
                    <div class="sm:col-span-12">
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-200 mt-6 mb-4">
                            Webmail
                        </h3>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="akses_webmail"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Link Akses
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="akses_webmail" name="akses_webmail" type="text"
                            value="{{ old('akses_webmail', $accessCredential->akses_webmail ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="https://...">
                        @error('akses_webmail')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="username_webmail"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Email
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="username_webmail" name="username_webmail" type="text"
                            value="{{ old('username_webmail', $accessCredential->username_webmail ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="email@example.com">
                        @error('username_webmail')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="password_webmail"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Password
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="password_webmail" name="password_webmail" type="password"
                            value="{{ old('password_webmail', $accessCredential->password_webmail ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Password">
                        @error('password_webmail')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="sm:col-span-3">
                        <label for="note" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Catatan
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <textarea id="note" name="note"
                            class="py-1.5 sm:py-2 px-3 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Catatan tambahan (opsional)" rows="3">{{ old('note', $accessCredential->note ?? '') }}</textarea>
                        @error('note')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <!-- End Grid -->

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route($prefix . 'access-credentials.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ isset($accessCredential) ? 'Update Access Credential' : 'Simpan Access Credential' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
