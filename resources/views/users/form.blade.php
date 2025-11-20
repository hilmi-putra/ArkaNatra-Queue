@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 dark:bg-neutral-800">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ isset($user) ? 'Edit User' : 'Tambah User Baru' }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ isset($user) ? 'Update informasi user' : 'Buat akun user baru' }}
                </p>
                @if (!isset($user))
                    <p class="text-sm text-blue-600 dark:text-blue-400 mt-1">
                        Password default: <strong>password123</strong>
                    </p>
                @endif
            </div>

            <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                method="POST">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                    <div class="sm:col-span-3">
                        <label for="name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Nama Lengkap *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="name" name="name" type="text" value="{{ old('name', $user->name ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan nama lengkap" required>
                        @error('name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="email" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Email *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="email" name="email" type="email" value="{{ old('email', $user->email ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="user@example.com" required>
                        @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="role" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Role *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="role" name="role"
                            class="py-1.5 sm:py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="">Pilih Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}"
                                    {{ old('role', isset($user) ? $user->roles->first()->name ?? '' : '') == $role->name ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="id_divisi" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Divisi
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="id_divisi" name="id_divisi"
                            class="py-1.5 sm:py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600">
                            <option value="">Pilih Divisi</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('id_divisi', $user->id_divisi ?? '') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_divisi')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <!-- End Grid -->

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('admin.users.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ isset($user) ? 'Update User' : 'Simpan User' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
