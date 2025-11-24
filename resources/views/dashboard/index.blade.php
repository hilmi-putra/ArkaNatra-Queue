@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

    <!-- Header -->
    <div
        class="py-3 px-4 flex flex-wrap justify-between items-center gap-2 bg-white border-b border-gray-200 dark:bg-neutral-800 dark:border-neutral-700">
        <div>
            <h1 class="font-semibold text-xl text-gray-800 dark:text-neutral-200">
                
            </h1>

            <p class="text-sm text-gray-600 dark:text-neutral-400">
                Welcome back, {{ auth()->user()->name  }}!
            </p>
        </div>

    </div>

    <!-- Body -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        @role('admin')
            @include('dashboard.admin')
        @endrole
        @role('production')
            @include('dashboard.production')
        @endrole
        @role('sales')
            @include('dashboard.sales')
        @endrole
        @role('asservice')
            @include('dashboard.asservice')
        @endrole
    </div>


@endsection
