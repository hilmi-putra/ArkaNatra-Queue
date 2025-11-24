@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 dark:bg-neutral-800">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ isset($indexingType) ? 'Edit Indexing Type' : 'Tambah Indexing Type Baru' }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ isset($indexingType) ? 'Update data indexing type' : 'Buat indexing type baru' }}
                </p>
            </div>

            <form
                action="{{ isset($indexingType) ? route('admin.indexing-types.update', $indexingType->id) : route('admin.indexing-types.store') }}"
                method="POST">
                @csrf
                @if (isset($indexingType))
                    @method('PUT')
                @endif

                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                    <!-- Indexing Name -->
                    <div class="sm:col-span-3">
                        <label for="indexing_name" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Nama Indexing *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <input id="indexing_name" name="indexing_name" type="text" 
                            value="{{ old('indexing_name', $indexingType->indexing_name ?? '') }}"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan nama indexing type" required>
                        @error('indexing_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-3">
                        <label for="description" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Deskripsi
                        </label>
                        <p class="text-xs text-gray-500 dark:text-neutral-400 mt-1">
                            Penjelasan tentang indexing type
                        </p>
                    </div>

                    <div class="sm:col-span-9">
                        <textarea id="description" name="description" rows="4"
                            class="py-1.5 sm:py-2 px-3 pe-11 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            placeholder="Masukkan deskripsi indexing type">{{ old('description', $indexingType->description ?? '') }}</textarea>
                        @error('description')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <!-- End Grid -->

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('admin.indexing-types.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ isset($indexingType) ? 'Update Indexing Type' : 'Simpan Indexing Type' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection