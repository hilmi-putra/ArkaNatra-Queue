<!-- ========== MAIN SIDEBAR ========== -->
<!-- Sidebar -->
<div id="hs-pro-sidebar"
    class="hs-overlay [--body-scroll:true] lg:[--overlay-backdrop:false] [--is-layout-affect:true] [--opened:lg] [--auto-close:lg]
hs-overlay-open:translate-x-0 lg:hs-overlay-layout-open:translate-x-0
-translate-x-full transition-all duration-300 transform
w-60
hidden
fixed inset-y-0 z-60 start-0
bg-zinc-100
lg:block lg:-translate-x-full lg:end-auto lg:bottom-0
dark:bg-neutral-900"
    role="dialog" tabindex="-1" aria-label="Sidebar">

    <!-- CSS untuk Active Link: Diatur di sini karena tidak ada file CSS terpisah -->
    <style>
        .active-link {
            /* Warna latar belakang dan teks saat menu aktif */
            background-color: #e0f2fe;
            /* blue-100 */
            color: #1d4ed8 !important;
            /* blue-700 */
            font-weight: 600;
        }

        .dark .active-link {
            /* Warna latar belakang dan teks saat menu aktif dalam mode gelap */
            background-color: rgba(29, 78, 216, 0.2);
            /* blue-700 with opacity */
            color: #93c5fd !important;
            /* blue-300 */
        }

        .active-link svg {
            /* Warna ikon saat menu aktif */
            color: #1d4ed8;
            /* blue-700 */
        }

        .dark .active-link svg {
            color: #93c5fd;
            /* blue-300 */
        }
    </style>

    <div class="lg:pt-13 relative flex flex-col h-full max-h-full">
        <!-- Body -->
        <nav
            class="p-3 size-full flex flex-col overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-200 [&::-webkit-scrollbar-thumb]:bg-gray-300 dark:[&::-webkit-scrollbar-track]:bg-neutral-700 dark:[&::-webkit-scrollbar-thumb]:bg-neutral-500">
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

            <div class="lg:hidden mb-2 flex items-center justify-between">
                <button type="button"
                    class="flex items-center gap-x-1.5 py-2 px-2.5 font-medium text-xs bg-black text-white rounded-lg focus:outline-hidden disabled:opacity-50 disabled:pointer-events-none dark:bg-white dark:text-black">
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" viewBox="0 0 16 16">
                        <path
                            d="M7.657 6.247c.11-.33.576-.33.686 0l.645 1.937a2.89 2.89 0 0 0 1.829 1.828l1.936.645c.33.11.33.576 0 .686l-1.937.645a2.89 2.89 0 0 0-1.828 1.829l-.645 1.936a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828l-.645-1.937a.361.361 0 0 1-.686 0l-.645-1.937a2.89 2.89 0 0 0-1.828-1.828l-1.937-.645a.361.361 0 0 1 0-.686l1.937-.645a2.89 2.89 0 0 0 1.828-1.828zM3.794 1.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387A1.73 1.73 0 0 0 4.593 5.69l-.387 1.162a.217.217 0 0 1-.412 0L3.407 5.69A1.73 1.73 0 0 0 2.31 4.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387A1.73 1.73 0 0 0 3.407 2.31zM10.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732L9.1 2.137a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z" />
                    </svg>
                    Ask AI
                </button>

                <!-- Sidebar Toggle -->
                <button type="button"
                    class="p-1.5 size-7.5 inline-flex items-center gap-x-1 text-xs rounded-md text-gray-500 disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden dark:text-neutral-500"
                    aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-pro-sidebar"
                    data-hs-overlay="#hs-pro-sidebar">
                    <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                    <span class="sr-only">Sidebar Toggle</span>
                </button>
                <!-- End Sidebar Toggle -->
            </div>

            <button type="button"
                class="p-1.5 ps-2.5 w-full inline-flex items-center gap-x-2 text-sm rounded-lg bg-white border border-gray-200 text-gray-600 shadow-xs hover:border-gray-300 focus:outline-hidden focus:border-gray-300 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-400 dark:hover:border-neutral-600 dark:focus:border-neutral-600"
                aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-pro-cmsssm"
                data-hs-overlay="#hs-pro-cmsssm">
                Search
                <span
                    class="ms-auto flex items-center gap-x-1 py-px px-1.5 border border-gray-200 rounded-md dark:border-neutral-700">
                    <svg class="shrink-0 size-2.5" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M15 6v12a3 3 0 1 0 3-3H6a3 3 0 1 0 3 3V6a3 3 0 1 0-3 3h12a3 3 0 1 0-3-3"></path>
                    </svg>
                    <span class="text-[11px] uppercase">k</span>
                </span>
            </button>

            <!-- Kategori: Home -->
            <div
                class="pt-3 mt-3 flex flex-col border-t border-gray-200 first:border-t-0 first:pt-0 first:mt-0 dark:border-neutral-700">
                <span class="block ps-2.5 mb-2 font-medium text-xs uppercase text-gray-500 dark:text-neutral-500">
                    Home
                </span>

                <!-- List -->
                <ul class="flex flex-col gap-y-1">
                    <li>
                        @php $isActive = request()->routeIs($prefix . 'dashboard'); @endphp
                        <a class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 dark:text-neutral-200 {{ $isActive ? 'active-link' : '' }}"
                            href="{{ route($prefix . 'dashboard') }}">
                            <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                <polyline points="9 22 9 12 15 12 15 22" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                </ul>
                <!-- End List -->
            </div>

            <!-- Kategori: Pages -->
            <div
                class="pt-3 mt-3 flex flex-col border-t border-gray-200 first:border-t-0 first:pt-0 first:mt-0 dark:border-neutral-700">
                <span class="block ps-2.5 mb-2 font-medium text-xs uppercase text-gray-500 dark:text-neutral-500">
                    Main Data
                </span>
                <!-- List -->
                <ul class="flex flex-col gap-y-1">
                    <!-- Users (Admin Only) -->
                    @if ($role === 'admin')
                        <li>
                            @php $isActive = request()->routeIs($prefix . 'users.index'); @endphp
                            <a href="{{ route($prefix . 'users.index') }}"
                                class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 {{ $isActive ? 'active-link' : '' }}">
                                <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                    <circle cx="12" cy="7" r="4" />
                                </svg>
                                Users
                            </a>
                        </li>
                    @endif

                    <!-- Customers -->
                    <li>
                        @php $isActive = request()->routeIs($prefix . 'customers.index'); @endphp
                        <a href="{{ route($prefix . 'customers.index') }}"
                            class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 {{ $isActive ? 'active-link' : '' }}">
                            <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="4" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                            Customers
                        </a>
                    </li>

                    <!-- Divisions -->
                    @role('admin')
                        <li>
                            @php $isActive = request()->routeIs($prefix . 'divisions.index'); @endphp
                            <a href="{{ route($prefix . 'divisions.index') }}"
                                class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 {{ $isActive ? 'active-link' : '' }}">
                                <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <rect x="3" y="3" width="7" height="7" />
                                    <rect x="14" y="3" width="7" height="7" />
                                    <rect x="14" y="14" width="7" height="7" />
                                    <rect x="3" y="14" width="7" height="7" />
                                </svg>
                                Divisions
                            </a>
                        </li>
                    @endrole


                </ul>
                <!-- End List -->
            </div>


            <!-- Kategori: Others -->
            <div
                class="pt-3 mt-3 flex flex-col border-t border-gray-200 first:border-t-0 first:pt-0 first:mt-0 dark:border-neutral-700">
                <span class="block ps-2.5 mb-2 font-medium text-xs uppercase text-gray-500 dark:text-neutral-500">
                    Work Sheets
                </span>

                <ul>

                    <!-- Work Types -->
                    <li>
                        @php $isActive = request()->routeIs($prefix . 'work-types.index'); @endphp
                        <a href="{{ route($prefix . 'work-types.index') }}"
                            class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 {{ $isActive ? 'active-link' : '' }}">
                            <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 15v4c0 1.1.9 2 2 2h14a2 2 0 0 0 2-2v-4" />
                                <polyline points="17 9 12 4 7 9" />
                                <line x1="12" x2="12" y1="4" y2="20" />
                            </svg>
                            Work Types
                        </a>
                    </li>

                    <!-- Work Orders with Submenu -->
                    <li class="hs-accordion" id="work-orders-accordion">
                        @php
                            $statusRoutes = [
                                'work-orders.status.validate',
                                'work-orders.status.queue',
                                'work-orders.status.pending',
                                'work-orders.status.progress',
                                'work-orders.status.revision',
                                'work-orders.status.migration',
                                'work-orders.status.finish',
                            ];
                            $isActive =
                                request()->routeIs($prefix . 'work-orders.index') ||
                                collect($statusRoutes)->some(fn($route) => request()->routeIs($prefix . $route));
                        @endphp

                        <button type="button"
                            class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 {{ $isActive ? 'active-link' : '' }}"
                            aria-expanded="{{ $isActive ? 'true' : 'false' }}"
                            aria-controls="work-orders-accordion-child">
                            <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                <path d="M14 2v6h6" />
                                <path d="M16 13H8" />
                                <path d="M16 17H8" />
                                <path d="M10 9H8" />
                            </svg>
                            Work Orders

                            <svg class="hs-accordion-active:block ms-auto hidden size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m18 15-6-6-6 6" />
                            </svg>

                            <svg class="hs-accordion-active:hidden ms-auto block size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6" />
                            </svg>
                        </button>

                        <div id="work-orders-accordion-child"
                            class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ $isActive ? '' : 'hidden' }}"
                            role="region" aria-labelledby="work-orders-accordion">

                            <ul class="hs-accordion-group ps-8 pt-1 space-y-1" data-hs-accordion-always-open>
                                @php
                                    use App\Models\WorkOrderModel;
                                    use Illuminate\Support\Facades\Auth;

                                    $user = Auth::user();
                                    $userId = $user->id;
                                    $role = $user->getRoleNames()->first();

                                    // Role yang bisa melihat semua data
                                    $supervisorRoles = ['admin', 'asservice'];

                                    // Buat query
                                    $userWorkOrdersQuery = WorkOrderModel::query();

                                    // Tambahkan filter jika user bukan supervisor
                                    // Perbaikan: Gunakan in_array() untuk pengecekan role
                                    if (!in_array($role, $supervisorRoles)) {
                                        $userWorkOrdersQuery->where(function ($query) use ($userId) {
                                            $query->where('production_id', $userId)->orWhere('sales_id', $userId);
                                        });
                                    }

                                    // Hitung total work orders
                                    $totalWorkOrders = $userWorkOrdersQuery->count();

                                    // Hitung per status dengan group by
                                    $statusCounts = $userWorkOrdersQuery
                                        ->clone()
                                        ->selectRaw('status, count(*) as count')
                                        ->groupBy('status')
                                        ->pluck('count', 'status')
                                        ->toArray();

                                    $totalStatusCount = array_sum($statusCounts);

                                    $validateCount = $statusCounts['validate'] ?? 0;
                                    $queueCount = $statusCounts['queue'] ?? 0;
                                    $pendingCount = $statusCounts['pending'] ?? 0;
                                    $progressCount = $statusCounts['progress'] ?? 0;
                                    $revisionCount = $statusCounts['revision'] ?? 0;
                                    $migrationCount = $statusCounts['migration'] ?? 0;
                                    $finishCount = $statusCounts['finish'] ?? 0;
                                @endphp

                                <!-- All Work Orders -->
                                <li>
                                    <a href="{{ route($prefix . 'work-orders.index') }}"
                                        class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 {{ request()->routeIs($prefix . 'work-orders.index') ? 'active-link' : '' }}">
                                        <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                                            <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9" />
                                            <path d="M12 3v6" />
                                        </svg>
                                        All Work Orders
                                        <!-- Badge untuk All Work Orders -->
                                        <span
                                            class="inline-flex items-center justify-center ms-auto size-5 text-xs font-medium text-white bg-blue-600 rounded-full">
                                            {{ $totalWorkOrders }}
                                        </span>
                                    </a>
                                </li>

                                <!-- Status Accordion -->
                                <li class="hs-accordion" id="work-orders-status-accordion">
                                    @php
                                        $statusActive = collect($statusRoutes)->some(
                                            fn($route) => request()->routeIs($prefix . $route),
                                        );
                                    @endphp

                                    <button type="button"
                                        class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 {{ $statusActive ? 'active-link' : '' }}"
                                        aria-expanded="{{ $statusActive ? 'true' : 'false' }}"
                                        aria-controls="work-orders-status-accordion-child">
                                        <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="12" cy="12" r="10" />
                                            <path d="M12 16v-4" />
                                            <path d="M12 8h.01" />
                                        </svg>
                                        Status

                                        <!-- Badge untuk total semua status -->
                                        <span
                                            class="inline-flex items-center justify-center ms-auto size-5 text-xs font-medium text-white bg-gray-600 rounded-full">
                                            {{ $totalStatusCount }}
                                        </span>

                                        <svg class="hs-accordion-active:block ms-2 hidden size-4"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m18 15-6-6-6 6" />
                                        </svg>

                                        <svg class="hs-accordion-active:hidden ms-2 block size-4"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="m6 9 6 6 6-6" />
                                        </svg>
                                    </button>

                                    <div id="work-orders-status-accordion-child"
                                        class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300 {{ $statusActive ? '' : 'hidden' }}"
                                        role="region" aria-labelledby="work-orders-status-accordion">

                                        <ul class="pt-1 space-y-1">
                                            @php
                                                $statuses = [
                                                    'validate' => [
                                                        'label' => 'Validate',
                                                        'color' => 'blue',
                                                        'count' => $validateCount,
                                                        'icon' =>
                                                            '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                                    ],
                                                    'queue' => [
                                                        'label' => 'Queue',
                                                        'color' => 'purple',
                                                        'count' => $queueCount,
                                                        'icon' =>
                                                            '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                                    ],
                                                    'pending' => [
                                                        'label' => 'Pending',
                                                        'color' => 'yellow',
                                                        'count' => $pendingCount,
                                                        'icon' =>
                                                            '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                                    ],
                                                    'progress' => [
                                                        'label' => 'Progress',
                                                        'color' => 'indigo',
                                                        'count' => $progressCount,
                                                        'icon' => '<path d="M13 10V3L4 14h7v7l9-11h-7z"/>',
                                                    ],
                                                    'revision' => [
                                                        'label' => 'Revision',
                                                        'color' => 'red',
                                                        'count' => $revisionCount,
                                                        'icon' =>
                                                            '<path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
                                                    ],
                                                    'migration' => [
                                                        'label' => 'Migration',
                                                        'color' => 'orange',
                                                        'count' => $migrationCount,
                                                        'icon' =>
                                                            '<path d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>',
                                                    ],
                                                    'finish' => [
                                                        'label' => 'Finish',
                                                        'color' => 'green',
                                                        'count' => $finishCount,
                                                        'icon' =>
                                                            '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                                                    ],
                                                ];
                                            @endphp

                                            @foreach ($statuses as $statusKey => $statusData)
                                                @php
                                                    // Tentukan class warna badge menggunakan if else
                                                    if ($statusData['color'] == 'blue') {
                                                        $badgeColor = 'bg-blue-500';
                                                    } elseif ($statusData['color'] == 'purple') {
                                                        $badgeColor = 'bg-purple-500';
                                                    } elseif ($statusData['color'] == 'yellow') {
                                                        $badgeColor = 'bg-yellow-500';
                                                    } elseif ($statusData['color'] == 'indigo') {
                                                        $badgeColor = 'bg-indigo-500';
                                                    } elseif ($statusData['color'] == 'red') {
                                                        $badgeColor = 'bg-red-500';
                                                    } elseif ($statusData['color'] == 'orange') {
                                                        $badgeColor = 'bg-orange-500';
                                                    } elseif ($statusData['color'] == 'green') {
                                                        $badgeColor = 'bg-green-500';
                                                    } else {
                                                        $badgeColor = 'bg-gray-500';
                                                    }
                                                @endphp

                                                <li>
                                                    <a href="{{ route($prefix . 'work-orders.status.' . $statusKey) }}"
                                                        class="flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 dark:bg-neutral-800 dark:hover:bg-neutral-700 dark:focus:bg-neutral-700 dark:text-neutral-200 {{ request()->routeIs($prefix . 'work-orders.status.' . $statusKey) ? 'active-link' : '' }}">
                                                        <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                                            xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round">
                                                            {!! $statusData['icon'] !!}
                                                        </svg>
                                                        {{ $statusData['label'] }}
                                                        <!-- Badge untuk setiap status -->
                                                        <span
                                                            class="inline-flex items-center justify-center ms-auto size-5 text-xs font-medium text-white {{ $badgeColor }} rounded-full">
                                                            {{ $statusData['count'] }}
                                                        </span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                                <!-- End Status Accordion -->
                            </ul>
                        </div>
                    </li>

                    <!-- Indexing Types -->
                    <li>
                        @php $isActive = request()->routeIs($prefix . 'indexing-types.index'); @endphp
                        <a href="{{ route($prefix . 'indexing-types.index') }}"
                            class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 {{ $isActive ? 'active-link' : '' }}">
                            <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                            Indexing Types
                        </a>
                    </li>

                    <!-- Work Order Indexing -->
                    <li>
                        @php $isActive = request()->routeIs($prefix . 'work-order-indexing.index'); @endphp
                        <a href="{{ route($prefix . 'work-order-indexing.index') }}"
                            class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 {{ $isActive ? 'active-link' : '' }}">
                            <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M19.8 17.6a2.14 2.14 0 0 0 1.25-1.9v-11.4a2.14 2.14 0 0 0-1.25-1.9L12 1 4.2 3.6a2.14 2.14 0 0 0-1.25 1.9v11.4a2.14 2.14 0 0 0 1.25 1.9l7.8 2.6z" />
                                <path d="m9 9 3 2 3-2" />
                                <path d="m9 15 3 2 3-2" />
                            </svg>
                            Work Order Indexing
                        </a>
                    </li>

                    <!-- Access Credentials -->
                    <li>
                        @php $isActive = request()->routeIs($prefix . 'access-credentials.index'); @endphp
                        <a href="{{ route($prefix . 'access-credentials.index') }}"
                            class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 dark:text-neutral-200 dark:hover:bg-neutral-800 {{ $isActive ? 'active-link' : '' }}">
                            <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="18" height="11" x="3" y="11" rx="2" ry="2" />
                                <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                            </svg>
                            Access Credentials
                        </a>
                    </li>
                </ul>
                <!-- End List -->
            </div>
        </nav>
        <!-- End Body -->

        <!-- Footer -->
        <footer class="mt-auto p-3 flex flex-col">
            <!-- List -->
            <ul class="flex flex-col gap-y-1">
                <li>
                    <a class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 dark:text-neutral-200"
                        href="#">
                        <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path
                                d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-4.054 2-6 .5 2.5 2 4.9 4 6.5 2 1.6 3 3.5 3 5.5a7 7 0 1 1-14 0c0-1.153.433-2.294 1-3a2.5 2.5 0 0 0 2.5 2.5z" />
                        </svg>
                        What's new?
                    </a>
                </li>
                <li>
                    <a class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 dark:text-neutral-200"
                        href="#">
                        <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z" />
                        </svg>
                        Help & support
                    </a>
                </li>
                <li class="lg:hidden">
                    <a class="w-full flex items-center gap-x-2 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-200 focus:outline-hidden focus:bg-gray-200 dark:hover:bg-neutral-800 dark:focus:bg-neutral-800 dark:text-neutral-200"
                        href="#">
                        <svg class="shrink-0 size-4 text-gray-600 dark:text-neutral-400"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M12 7v14" />
                            <path
                                d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                        </svg>
                        Knowledge Base
                    </a>
                </li>
            </ul>
            <!-- End List -->
        </footer>
        <!-- End Footer -->
    </div>
</div>
<!-- End Sidebar -->
<!-- ========== END MAIN SIDEBAR ========== -->
