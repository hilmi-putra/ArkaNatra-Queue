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
            </div>

            <form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                method="POST" id="user-form">
                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif

                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                    <!-- Nama Lengkap -->
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

                    <!-- Email -->
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

                    <!-- Role -->
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

                    <!-- Divisi -->
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

                    <!-- Password Baru (Hanya untuk edit) -->
                    @if(isset($user))
                    <div class="sm:col-span-3">
                        <label for="new_password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Password Baru
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <div class="space-y-2">
                            <input id="new_password" name="new_password" type="text"
                                class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                placeholder="Masukkan password baru (kosongkan jika tidak diubah)"
                                value="">
                            <div class="flex items-center space-x-4">
                                <button type="button" onclick="generatePassword()" 
                                    class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 hover:underline">
                                    Generate Password
                                </button>
                                <button type="button" onclick="showPassword('new_password')" 
                                    class="text-sm text-gray-600 hover:text-gray-800 dark:text-gray-400 hover:underline">
                                    Tampilkan/Sembunyikan
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Password akan ditampilkan dalam bentuk teks biasa untuk memudahkan copy
                            </p>
                        </div>
                        @error('new_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

                    <!-- Password Admin (Verifikasi) - Hanya untuk edit -->
                    @if(isset($user))
                    <div class="sm:col-span-3">
                        <label for="admin_password" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Password Admin *
                        </label>
                    </div>
                    <div class="sm:col-span-9">
                        <div class="space-y-2">
                            <div class="relative">
                                <input id="admin_password" name="admin_password" type="password"
                                    class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                                    placeholder="Masukkan password admin untuk verifikasi"
                                    required>
                                <button type="button" onclick="togglePasswordVisibility('admin_password')"
                                    class="absolute inset-y-0 end-0 flex items-center pe-3 text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">
                                    <svg id="admin_password_icon" class="size-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                Masukkan password akun Anda untuk verifikasi perubahan
                            </p>
                        </div>
                        @error('admin_password')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    @endif

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

<script>
function togglePasswordVisibility(fieldId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
        `;
    } else {
        input.type = 'password';
        icon.innerHTML = `
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
        `;
    }
}

function showPassword(fieldId) {
    const input = document.getElementById(fieldId);
    if (input.type === 'password') {
        input.type = 'text';
    } else {
        input.type = 'password';
    }
}

function generatePassword() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
    let password = '';
    for (let i = 0; i < 12; i++) {
        password += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.getElementById('new_password').value = password;
    document.getElementById('new_password').type = 'text';
    
    // Show notification
    showNotification('Password berhasil digenerate!', 'success');
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-2 rounded-lg shadow-lg ${
        type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Form validation
document.getElementById('user-form').addEventListener('submit', function(e) {
    const newPassword = document.getElementById('new_password')?.value;
    const adminPassword = document.getElementById('admin_password')?.value;
    
    if (newPassword && newPassword.trim() !== '') {
        if (!adminPassword || adminPassword.trim() === '') {
            e.preventDefault();
            alert('Harap masukkan password admin untuk verifikasi perubahan password');
            document.getElementById('admin_password').focus();
        } else if (newPassword.length < 6) {
            e.preventDefault();
            alert('Password baru minimal 6 karakter');
            document.getElementById('new_password').focus();
        }
    }
});
</script>
