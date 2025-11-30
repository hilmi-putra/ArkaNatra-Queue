@extends('layouts.app')

@section('content')
    <!-- Card Section -->
    <div class="px-4 py-10 sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-xs p-4 sm:p-7 dark:bg-neutral-800">
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-800 dark:text-neutral-200">
                    {{ isset($workOrderIndexing) ? 'Edit Work Order Indexing' : 'Tambah Work Order Indexing' }}
                </h2>
                <p class="text-sm text-gray-600 dark:text-neutral-400">
                    {{ isset($workOrderIndexing) ? 'Update indexing' : 'Buat indexing baru untuk work order' }}
                </p>
            </div>

            <form
                action="{{ isset($workOrderIndexing) ? route('asservice.work-order-indexing.update', $workOrderIndexing->id) : route('asservice.work-order-indexing.store') }}"
                method="POST">
                @csrf
                @if (isset($workOrderIndexing))
                    @method('PUT')
                @endif

                <!-- Grid -->
                <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">

                    <div class="sm:col-span-3">
                        <label for="work_order_id" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Work Order *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="work_order_id" name="work_order_id"
                            class="py-1.5 sm:py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="">Pilih Work Order</option>
                            @foreach ($workOrders as $wo)
                                <option value="{{ $wo->id }}"
                                    {{ old('work_order_id', $workOrderIndexing->work_order_id ?? '') == $wo->id ? 'selected' : '' }}>
                                    #{{ $wo->ref_id }} - {{ $wo->customer_name ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                        @error('work_order_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="indexing_type_id"
                            class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Indexing Type *
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <select id="indexing_type_id" name="indexing_type_id"
                            class="py-1.5 sm:py-2 px-3 pe-9 block w-full border-gray-200 shadow-2xs rounded-lg sm:text-sm focus:border-blue-500 focus:ring-blue-500 checked:border-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600"
                            required>
                            <option value="">Pilih Indexing Type</option>
                            @foreach ($indexingTypes as $it)
                                <option value="{{ $it->id }}"
                                    {{ old('indexing_type_id', $workOrderIndexing->indexing_type_id ?? '') == $it->id ? 'selected' : '' }}>
                                    {{ $it->indexing_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('indexing_type_id')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-3">
                        <label for="finished" class="inline-block text-sm text-gray-800 mt-2.5 dark:text-neutral-200">
                            Finished
                        </label>
                    </div>

                    <div class="sm:col-span-9">
                        <label class="inline-flex items-center">
                            <input type="checkbox" id="finished" name="finished" value="1" class="mr-2"
                                {{ old('finished', isset($workOrderIndexing) ? $workOrderIndexing->finished : '') ? 'checked' : '' }}>
                            <span class="text-sm text-gray-700 dark:text-neutral-300">Tandai sebagai selesai</span>
                        </label>
                        @error('finished')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
                <!-- End Grid -->

                <div class="mt-5 flex justify-end gap-x-2">
                    <a href="{{ route('asservice.work-order-indexing.index') }}"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-50 dark:bg-transparent dark:border-neutral-700 dark:text-neutral-300 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800">
                        Batal
                    </a>
                    <button type="submit"
                        class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        {{ isset($workOrderIndexing) ? 'Update Indexing' : 'Simpan Indexing' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection