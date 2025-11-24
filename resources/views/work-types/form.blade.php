@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 dark:bg-neutral-800">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ isset($workType) ? 'Edit Work Type' : 'Tambah Work Type Baru' }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ isset($workType) ? 'Update data work type' : 'Buat work type baru' }}
                </p>
            </div>

            <form
                action="{{ isset($workType) ? route('admin.work-types.update', $workType->id) : route('admin.work-types.store') }}"
                method="POST">
                @csrf
                @if (isset($workType))
                    @method('PUT')
                @endif

                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                    <!-- Work Type -->
                    <div class="sm:col-span-3">
                        <label for="work_type" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Work Type *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="work_type" name="work_type" type="text"
                            value="{{ old('work_type', $workType->work_type ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan nama work type" required>
                        @error('work_type')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Division -->
                    <div class="sm:col-span-3">
                        <label for="division_id" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Divisi *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="division_id" name="division_id"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="">Pilih Divisi</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}"
                                    {{ old('division_id', $workType->division_id ?? '') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('division_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Regular Estimation Days -->
                    <div class="sm:col-span-3">
                        <label for="regular_estimation_days"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Estimasi Hari Reguler *
                        </label>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">
                            Jumlah hari untuk pengerjaan normal
                        </p>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="regular_estimation_days" name="regular_estimation_days" type="number"
                            value="{{ old('regular_estimation_days', $workType->regular_estimation_days ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan jumlah hari" min="1" required>
                        @error('regular_estimation_days')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Extra Days Per Quantity -->
                    <div class="sm:col-span-3">
                        <label for="extra_days_per_quantity"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Hari Tambahan per Kuantitas *
                        </label>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">
                            Tambahan hari berdasarkan jumlah item
                        </p>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="extra_days_per_quantity" name="extra_days_per_quantity" type="number"
                            value="{{ old('extra_days_per_quantity', $workType->extra_days_per_quantity ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan jumlah hari tambahan" min="0" required>
                        @error('extra_days_per_quantity')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fast Track Estimation Days -->
                    <div class="sm:col-span-3">
                        <label for="fast_track_estimation_days"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Estimasi Hari Fast Track *
                        </label>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">
                            Jumlah hari untuk pengerjaan cepat
                        </p>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="fast_track_estimation_days" name="fast_track_estimation_days" type="number"
                            value="{{ old('fast_track_estimation_days', $workType->fast_track_estimation_days ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan jumlah hari fast track" min="1" required>
                        @error('fast_track_estimation_days')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <!-- End Grid -->

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('admin.work-types.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ isset($workType) ? 'Update Work Type' : 'Simpan Work Type' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
