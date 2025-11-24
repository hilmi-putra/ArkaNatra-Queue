@extends('layouts.app')

@section('content')
    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <!-- Header -->
            <div class="bg-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white">
                    {{ isset($workOrder) ? 'Edit' : 'Create' }} Work Order
                </h2>
            </div>

            <div class="p-6">
                <form
                    action="{{ isset($workOrder) ? route('asservice.work-orders.update', $workOrder->id) : route('asservice.work-orders.store') }}"
                    method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @if (isset($workOrder))
                        @method('PUT')
                    @endif

                    <!-- Section 1: Customer Data -->
                    <div class="bg-gray-50 border-l-4 border-blue-500 rounded-r-lg p-6">
                        <div class="flex items-center mb-4">
                            <span
                                class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">1</span>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Data Customer</h3>
                        </div>

                        <!-- Switch Button -->
                        <div class="mb-6">
                            <div class="flex items-center gap-4">
                                <span class="text-sm font-medium text-gray-700">Pilih Customer:</span>
                                <div class="flex items-center">
                                    <input type="radio" id="customer_existing" name="customer_type" value="existing"
                                        class="hidden peer/existing"
                                        {{ old('customer_type', isset($workOrder) ? 'existing' : 'new') === 'existing' ? 'checked' : '' }}>
                                    <label for="customer_existing"
                                        class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-l-lg cursor-pointer peer-checked/existing:bg-blue-500 peer-checked/existing:text-white peer-checked/existing:border-blue-500">
                                        Customer Existing
                                    </label>

                                    <input type="radio" id="customer_new" name="customer_type" value="new"
                                        class="hidden peer/new"
                                        {{ old('customer_type', isset($workOrder) ? 'existing' : 'new') === 'new' ? 'checked' : '' }}>
                                    <label for="customer_new"
                                        class="px-4 py-2 text-sm font-medium border border-gray-200 rounded-r-lg cursor-pointer peer-checked/new:bg-blue-500 peer-checked/new:text-white peer-checked/new:border-blue-500">
                                        Customer Baru
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Form Customer Existing (Select) -->
                        <div id="existing-customer-form" class="customer-form hidden">
                            <div>
                                <label for="existing_customer_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pilih Customer <span class="text-red-500">*</span>
                                </label>
                                <select name="existing_customer_id" id="existing_customer_id"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('existing_customer_id') border-red-500 @enderror">
                                    <option value="">Pilih Customer</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}"
                                            {{ old('existing_customer_id', isset($workOrder) ? $workOrder->customer_id : '') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} - {{ $customer->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('existing_customer_id')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Preview Customer Data -->
                            <div id="customer-preview" class="mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg hidden">
                                <h4 class="text-sm font-semibold text-gray-900 mb-2">Data Customer Terpilih:</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-600">Nama:</span>
                                        <span id="preview-name" class="font-medium text-gray-900"></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Email:</span>
                                        <span id="preview-email" class="font-medium text-gray-900"></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Telepon:</span>
                                        <span id="preview-phone" class="font-medium text-gray-900"></span>
                                    </div>
                                    <div>
                                        <span class="text-gray-600">Token:</span>
                                        <span id="preview-token" class="font-mono text-gray-900"></span>
                                    </div>
                                    <div class="col-span-2">
                                        <span class="text-gray-600">Alamat:</span>
                                        <span id="preview-address" class="font-medium text-gray-900"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Customer Baru (Input Manual) -->
                        <div id="new-customer-form" class="customer-form">
                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                                <!-- Customer Name -->
                                <div>
                                    <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Customer <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="customer_name" id="customer_name"
                                        value="{{ old('customer_name', isset($workOrder) ? $workOrder->customer->name : '') }}"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('customer_name') border-red-500 @enderror">
                                    @error('customer_name')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Customer Email -->
                                <div>
                                    <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-2">
                                        Email <span class="text-red-500">*</span>
                                    </label>
                                    <input type="email" name="customer_email" id="customer_email"
                                        value="{{ old('customer_email', isset($workOrder) ? $workOrder->customer->email : '') }}"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('customer_email') border-red-500 @enderror">
                                    @error('customer_email')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Customer Phone -->
                                <div>
                                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                                        No. Telepon <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="customer_phone" id="customer_phone"
                                        value="{{ old('customer_phone', isset($workOrder) ? $workOrder->customer->phone : '') }}"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('customer_phone') border-red-500 @enderror">
                                    @error('customer_phone')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Customer Address -->
                                <div class="sm:col-span-2">
                                    <label for="customer_address" class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="customer_address" id="customer_address" rows="3"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('customer_address') border-red-500 @enderror">{{ old('customer_address', isset($workOrder) ? $workOrder->customer->address : '') }}</textarea>
                                    @error('customer_address')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 border-l-4 border-blue-500 rounded-r-lg p-6">
                        <div class="flex items-center mb-4">
                            <span
                                class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">2</span>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Data Akses</h3>
                        </div>

                        <!-- Checkbox untuk memilih jenis akses -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Jenis Akses</label>
                            <div class="grid grid-cols-2 gap-4 sm:grid-cols-4">
                                <!-- OJS Checkbox -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" id="akses_ojs" name="access_types[]" value="ojs"
                                            class="hs-checkbox-checked:bg-blue-600 hs-checkbox-checked:border-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                            {{ isset($workOrder) && $workOrder->accessCredentials->where('akses_ojs', '!=', null)->count() > 0 ? 'checked' : '' }}>
                                    </div>
                                    <label for="akses_ojs"
                                        class="mx-3 ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                                        OJS
                                    </label>
                                </div>

                                <!-- cPanel Checkbox -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" id="akses_cpanel" name="access_types[]" value="cpanel"
                                            class="hs-checkbox-checked:bg-blue-600 hs-checkbox-checked:border-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                            {{ isset($workOrder) && $workOrder->accessCredentials->where('akses_cpanel', '!=', null)->count() > 0 ? 'checked' : '' }}>
                                    </div>
                                    <label for="akses_cpanel"
                                        class="mx-3 ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                                        cPanel
                                    </label>
                                </div>

                                <!-- Webmail Checkbox -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" id="akses_webmail" name="access_types[]" value="webmail"
                                            class="hs-checkbox-checked:bg-blue-600 hs-checkbox-checked:border-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                            {{ isset($workOrder) && $workOrder->accessCredentials->where('akses_webmail', '!=', null)->count() > 0 ? 'checked' : '' }}>
                                    </div>
                                    <label for="akses_webmail"
                                        class="mx-3 ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                                        Webmail
                                    </label>
                                </div>

                                <!-- Website Checkbox -->
                                <div class="relative flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="checkbox" id="akses_website" name="access_types[]" value="website"
                                            class="hs-checkbox-checked:bg-blue-600 hs-checkbox-checked:border-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                            {{ isset($workOrder) && $workOrder->accessCredentials->where('access_web', '!=', null)->count() > 0 ? 'checked' : '' }}>
                                    </div>
                                    <label for="akses_website"
                                        class="mx-3 ml-3 text-sm font-medium text-gray-700 cursor-pointer">
                                        Website
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Container untuk form akses yang dinamis -->
                        <div id="access-credentials" class="space-y-4">
                            <!-- OJS Form (akan muncul jika checkbox OJS dicentang) -->
                            <div id="ojs-form" class="access-form hidden bg-white border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-md font-semibold text-gray-900">Akses OJS</h4>
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">OJS</span>
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            URL OJS <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[ojs][url]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('akses_ojs', '!=', null)->akses_ojs ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="https://example.com/ojs">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Username <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[ojs][username]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('username_ojs', '!=', null)->username_ojs ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Username OJS">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" name="access_credentials[ojs][password]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('password_ojs', '!=', null)->password_ojs ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Password OJS">
                                    </div>
                                </div>
                            </div>

                            <!-- cPanel Form (akan muncul jika checkbox cPanel dicentang) -->
                            <div id="cpanel-form"
                                class="access-form hidden bg-white border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-md font-semibold text-gray-900">Akses cPanel</h4>
                                    <span
                                        class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">cPanel</span>
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            URL cPanel <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[cpanel][url]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('akses_cpanel', '!=', null)->akses_cpanel ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="https://example.com:2083">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Username <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[cpanel][username]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('username_cpanel', '!=', null)->username_cpanel ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Username cPanel">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" name="access_credentials[cpanel][password]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('password_cpanel', '!=', null)->password_cpanel ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Password cPanel">
                                    </div>
                                </div>
                            </div>

                            <!-- Webmail Form (akan muncul jika checkbox Webmail dicentang) -->
                            <div id="webmail-form"
                                class="access-form hidden bg-white border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-md font-semibold text-gray-900">Akses Webmail</h4>
                                    <span
                                        class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded">Webmail</span>
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            URL Webmail <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[webmail][url]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('akses_webmail', '!=', null)->akses_webmail ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="https://webmail.example.com">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Username <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[webmail][username]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('username_webmail', '!=', null)->username_webmail ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Username Webmail">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" name="access_credentials[webmail][password]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('password_webmail', '!=', null)->password_webmail ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Password Webmail">
                                    </div>
                                </div>
                            </div>

                            <!-- Website Form (akan muncul jika checkbox Website dicentang) -->
                            <div id="website-form"
                                class="access-form hidden bg-white border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-md font-semibold text-gray-900">Akses Website</h4>
                                    <span
                                        class="bg-orange-100 text-orange-800 text-xs font-medium px-2.5 py-0.5 rounded">Website</span>
                                </div>
                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            URL Website <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[website][url]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('access_web', '!=', null)->access_web ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="https://example.com">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Username <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="access_credentials[website][username]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('username_web', '!=', null)->username_web ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Username Website">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Password <span class="text-red-500">*</span>
                                        </label>
                                        <input type="password" name="access_credentials[website][password]"
                                            value="{{ isset($workOrder) ? $workOrder->accessCredentials->firstWhere('password_web', '!=', null)->password_web ?? '' : '' }}"
                                            class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                            placeholder="Password Website">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pesan jika tidak ada akses yang dipilih -->
                        <div id="no-access-message"
                            class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <p class="text-gray-500 text-sm">Pilih jenis akses di atas untuk menambahkan kredensial</p>
                        </div>

                        <!-- Field Catatan untuk semua akses -->
                        <div class="mt-6">
                            <label for="access_note" class="block text-sm font-medium text-gray-700 mb-2">
                                Catatan Akses
                            </label>
                            <textarea name="access_note" id="access_note" rows="3"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Catatan tambahan untuk semua akses yang dipilih">{{ isset($workOrder) ? $workOrder->accessCredentials->first()->note ?? '' : '' }}</textarea>
                        </div>
                    </div>

                    <!-- Section 3: Work Order Details & File Upload -->
                    <div class="bg-gray-50 border-l-4 border-blue-500 rounded-r-lg p-6">
                        <div class="flex items-center mb-4">
                            <span
                                class="flex-shrink-0 w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-semibold">3</span>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Detail Work Order & Upload File</h3>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <!-- Division -->
                            <div>
                                <label for="division_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Divisi <span class="text-red-500">*</span>
                                </label>
                                <select name="division_id" id="division_id"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('division_id') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Divisi</option>
                                    @foreach ($divisions as $division)
                                        <option value="{{ $division->id }}"
                                            {{ old('division_id', isset($workOrder) ? $workOrder->division_id : '') == $division->id ? 'selected' : '' }}>
                                            {{ $division->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Work Type -->
                            <div>
                                <label for="work_type_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Jenis Pekerjaan <span class="text-red-500">*</span>
                                </label>
                                <select name="work_type_id" id="work_type_id"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('work_type_id') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Jenis Pekerjaan</option>
                                    @foreach ($workTypes as $workType)
                                        <option value="{{ $workType->id }}"
                                            {{ old('work_type_id', isset($workOrder) ? $workOrder->work_type_id : '') == $workType->id ? 'selected' : '' }}>
                                            {{ $workType->work_type }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('work_type_id')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Domain -->
                            <div>
                                <label for="domain" class="block text-sm font-medium text-gray-700 mb-2">
                                    Domain
                                </label>
                                <input type="text" name="domain" id="domain"
                                    value="{{ old('domain', isset($workOrder) ? $workOrder->domain : '') }}"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('domain') border-red-500 @enderror">
                                @error('domain')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">
                                    Quantity <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="quantity" id="quantity"
                                    value="{{ old('quantity', isset($workOrder) ? $workOrder->quantity : 1) }}"
                                    min="1"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('quantity') border-red-500 @enderror"
                                    required>
                                @error('quantity')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Select Sales -->
                            <div>
                                <label for="sales_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    Sales <span class="text-red-500">*</span>
                                </label>
                                <select name="sales_id" id="sales_id"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('sales_id') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih Sales</option>
                                    @foreach ($salesUsers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('sales_id', $workOrder->sales_id ?? '') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sales_id')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Select Production -->
                            <div>
                                <label for="production_id" class="block text-sm font-medium text-gray-700 mb-2">
                                    PIC Production <span class="text-red-500">*</span>
                                </label>
                                <select name="production_id" id="production_id"
                                    class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('production_id') border-red-500 @enderror"
                                    required>
                                    <option value="">Pilih PIC Production</option>
                                    @foreach ($productionUsers as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('production_id', $workOrder->production_id ?? '') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} - {{ $user->email }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('production_id')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fast Track Button Group (Soft Colors) -->
                            <div class="sm:col-span-2">
                                <label for="fast_track" class="block text-sm font-medium text-gray-700 mb-2">
                                    Fast Track
                                </label>

                                <div class="flex flex-wrap justify-start gap-1.5 sm:gap-2">
                                    <!-- Fast Track Button -->
                                    <button type="button" id="fast_track_button"
                                        class="py-1.5 px-2.5 inline-flex items-center gap-x-1.5 text-sm rounded-lg focus:outline-hidden transition-colors duration-200 font-medium
                   {{ (isset($workOrder) && $workOrder->fast_track) || old('fast_track') == '1'
                       ? 'text-green-700 bg-green-100 hover:bg-green-200 border border-green-300'
                       : 'text-red-700 bg-red-100 hover:bg-red-200 border border-red-300' }}
                   dark:bg-neutral-700">

                                        <!-- Icon -->
                                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                            height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M5 18h3.5a2 2 0 0 1 1.6.8l1.5 2 3.5-5" />
                                            <path d="m2 12 5.5-3.5a2 2 0 0 1 2 0L15 12" />
                                            <path d="m22 12-5.5 3.5a2 2 0 0 1-2 0L9 12" />
                                            <path d="M12 2v8" />
                                        </svg>

                                        <!-- Button Text -->
                                        <span id="fast_track_text">
                                            {{ (isset($workOrder) && $workOrder->fast_track) || old('fast_track') == '1' ? 'ON' : 'OFF' }}
                                        </span>
                                    </button>

                                    <!-- Hidden Input for Form Submission -->
                                    <input type="hidden" name="fast_track" id="fast_track_input"
                                        value="{{ (isset($workOrder) && $workOrder->fast_track) || old('fast_track') == '1' ? '1' : '0' }}">
                                </div>

                                @error('fast_track')
                                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mt-6">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Pekerjaan <span class="text-red-500">*</span>
                            </label>
                            <textarea name="description" id="description" rows="4"
                                class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror"
                                required>{{ old('description', isset($workOrder) ? $workOrder->description : '') }}</textarea>
                            @error('description')
                                <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- File Uploads -->
                        <div class="mt-6">
                            <div
                                class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg dark:bg-blue-900/20 dark:border-blue-800">
                                <div class="flex items-start gap-3">
                                    <svg class="shrink-0 size-5 text-blue-600 dark:text-blue-400 mt-0.5"
                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z" />
                                        <polyline points="14 2 14 8 20 8" />
                                    </svg>
                                    <div class="text-sm">
                                        <span class="font-semibold text-blue-800 dark:text-blue-300">Petunjuk Upload
                                            File:</span>
                                        <ul class="text-blue-700 dark:text-blue-400 mt-1 space-y-1">
                                            <li>• Hanya file Word (.doc, .docx) dan PDF (.pdf) yang diperbolehkan</li>
                                            <li>• Maksimal ukuran file: 5MB per file</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                                <!-- File MOU -->
                                <div>
                                    <label for="file_mou" class="block text-sm font-medium text-gray-700 mb-2">
                                        File MOU
                                    </label>
                                    <input type="file" name="file_mou" id="file_mou"
                                        class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 @error('file_mou') border-red-500 @enderror
                file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4"
                                        accept=".doc,.docx,.pdf">
                                    @error('file_mou')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                    @if (isset($workOrder) && $workOrder->file_mou)
                                        <p class="text-sm text-gray-600 mt-2">
                                            File saat ini:
                                            <a href="{{ Storage::url($workOrder->file_mou) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800">
                                                Download
                                            </a>
                                        </p>
                                    @endif
                                </div>

                                <!-- File Work Form -->
                                <div>
                                    <label for="file_work_form" class="block text-sm font-medium text-gray-700 mb-2">
                                        File Work Form
                                    </label>
                                    <input type="file" name="file_work_form" id="file_work_form"
                                        class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 @error('file_work_form') border-red-500 @enderror
                file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4"
                                        accept=".doc,.docx,.pdf">
                                    @error('file_work_form')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                    @if (isset($workOrder) && $workOrder->file_work_form)
                                        <p class="text-sm text-gray-600 mt-2">
                                            File saat ini:
                                            <a href="{{ Storage::url($workOrder->file_work_form) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800">
                                                Download
                                            </a>
                                        </p>
                                    @endif
                                </div>

                                <!-- Additional File -->
                                <div>
                                    <label for="additional_file" class="block text-sm font-medium text-gray-700 mb-2">
                                        File Tambahan
                                    </label>
                                    <input type="file" name="additional_file" id="additional_file"
                                        class="block w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 @error('additional_file') border-red-500 @enderror
                file:bg-gray-50 file:border-0 file:me-4 file:py-3 file:px-4"
                                        accept=".doc,.docx,.pdf">
                                    @error('additional_file')
                                        <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                                    @enderror
                                    @if (isset($workOrder) && $workOrder->additional_file)
                                        <p class="text-sm text-gray-600 mt-2">
                                            File saat ini:
                                            <a href="{{ Storage::url($workOrder->additional_file) }}" target="_blank"
                                                class="text-blue-600 hover:text-blue-800">
                                                Download
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                            <a href="{{ route('asservice.work-orders.index') }}"
                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50">
                                Cancel
                            </a>
                            <button type="submit"
                                class="py-3 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700">
                                <svg class="flex-shrink-0 w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" />
                                    <polyline points="17 21 17 13 7 13 7 21" />
                                    <polyline points="7 3 7 8 15 8" />
                                </svg>
                                {{ isset($workOrder) ? 'Update' : 'Simpan' }} Work Order
                            </button>
                        </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const customerTypeRadios = document.querySelectorAll('input[name="customer_type"]');
        const existingForm = document.getElementById('existing-customer-form');
        const newForm = document.getElementById('new-customer-form');
        const existingCustomerSelect = document.getElementById('existing_customer_id');
        const customerPreview = document.getElementById('customer-preview');

        // Data customers dari server (bisa di-pass melalui controller)
        const customersData = @json($customers->keyBy('id')->toArray());

        // Function to toggle forms
        function toggleCustomerForms() {
            const selectedType = document.querySelector('input[name="customer_type"]:checked').value;

            if (selectedType === 'existing') {
                existingForm.classList.remove('hidden');
                newForm.classList.add('hidden');
                // Make existing customer required, new customer optional
                existingCustomerSelect.required = true;
                document.getElementById('customer_name').required = false;
                document.getElementById('customer_email').required = false;
                document.getElementById('customer_phone').required = false;
                document.getElementById('customer_address').required = false;
            } else {
                existingForm.classList.add('hidden');
                newForm.classList.remove('hidden');
                // Make new customer required, existing customer optional
                existingCustomerSelect.required = false;
                document.getElementById('customer_name').required = true;
                document.getElementById('customer_email').required = true;
                document.getElementById('customer_phone').required = true;
                document.getElementById('customer_address').required = true;
            }
        }

        // Function to show customer preview
        function showCustomerPreview(customerId) {
            const customer = customersData[customerId];
            if (customer) {
                document.getElementById('preview-name').textContent = customer.name;
                document.getElementById('preview-email').textContent = customer.email;
                document.getElementById('preview-phone').textContent = customer.phone;
                document.getElementById('preview-token').textContent = customer.token;
                document.getElementById('preview-address').textContent = customer.address;
                customerPreview.classList.remove('hidden');
            } else {
                customerPreview.classList.add('hidden');
            }
        }

        // Event listeners
        customerTypeRadios.forEach(radio => {
            radio.addEventListener('change', toggleCustomerForms);
        });

        existingCustomerSelect.addEventListener('change', function() {
            showCustomerPreview(this.value);
        });

        // Initialize forms based on current selection
        toggleCustomerForms();

        // Show preview if editing and customer is selected
        @if (isset($workOrder))
            showCustomerPreview({{ $workOrder->customer_id }});
        @endif
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fungsi untuk menampilkan/menyembunyikan form berdasarkan checkbox
        function toggleAccessForm(checkboxId, formId) {
            const checkbox = document.getElementById(checkboxId);
            const form = document.getElementById(formId);
            const noAccessMessage = document.getElementById('no-access-message');

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    form.classList.remove('hidden');
                } else {
                    form.classList.add('hidden');
                }

                // Tampilkan/sembunyikan pesan "no access"
                updateNoAccessMessage();
            });

            // Initialize form visibility based on initial checkbox state
            if (checkbox.checked) {
                form.classList.remove('hidden');
            }
        }

        // Fungsi untuk update pesan "no access"
        function updateNoAccessMessage() {
            const noAccessMessage = document.getElementById('no-access-message');
            const visibleForms = document.querySelectorAll('.access-form:not(.hidden)');

            if (visibleForms.length === 0) {
                noAccessMessage.classList.remove('hidden');
            } else {
                noAccessMessage.classList.add('hidden');
            }
        }

        // Initialize semua form akses
        toggleAccessForm('akses_ojs', 'ojs-form');
        toggleAccessForm('akses_cpanel', 'cpanel-form');
        toggleAccessForm('akses_webmail', 'webmail-form');
        toggleAccessForm('akses_website', 'website-form');

        // Initialize pesan "no access" saat pertama kali load
        updateNoAccessMessage();
    });
</script>

<!-- JavaScript for Toggle Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fastTrackButton = document.getElementById('fast_track_button');
        const fastTrackText = document.getElementById('fast_track_text');
        const fastTrackInput = document.getElementById('fast_track_input');

        fastTrackButton.addEventListener('click', function() {
            // Toggle the value
            const isActive = fastTrackInput.value === '1';
            fastTrackInput.value = isActive ? '0' : '1';

            // Update button appearance
            if (fastTrackInput.value === '1') {
                // ON State - Green (Success)
                fastTrackButton.classList.remove('text-red-700', 'bg-red-100', 'hover:bg-red-200',
                    'border-red-300');
                fastTrackButton.classList.add('text-green-700', 'bg-green-100', 'hover:bg-green-200',
                    'border-green-300');
                fastTrackText.textContent = 'ON';
            } else {
                // OFF State - Red
                fastTrackButton.classList.remove('text-green-700', 'bg-green-100', 'hover:bg-green-200',
                    'border-green-300');
                fastTrackButton.classList.add('text-red-700', 'bg-red-100', 'hover:bg-red-200',
                    'border-red-300');
                fastTrackText.textContent = 'OFF';
            }
        });
    });
</script>
