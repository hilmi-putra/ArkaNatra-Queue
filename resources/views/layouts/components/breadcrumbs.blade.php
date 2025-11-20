@php
    // Generate breadcrumbs automatically if not provided
    if (!isset($breadcrumbs)) {
        $breadcrumbs = generate_breadcrumbs();
    }
@endphp

@if(!empty($breadcrumbs) && count($breadcrumbs) > 1)
<nav class="mb-6" aria-label="Breadcrumb">
    <ol class="flex items-center gap-2 flex-wrap">
        @foreach($breadcrumbs as $index => $breadcrumb)
            <li class="inline-flex items-center gap-2">
                @if(!$loop->first)
                    <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-600" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                @endif

                @if($breadcrumb['url'] && !$breadcrumb['active'])
                    <a href="{{ $breadcrumb['url'] }}" 
                       class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-blue-600 dark:text-neutral-400 dark:hover:text-blue-500 transition-colors duration-200">
                        @if($loop->first)
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        @endif
                        {{ $breadcrumb['label'] }}
                    </a>
                @else
                    <span class="inline-flex items-center gap-2 text-sm font-medium text-gray-800 dark:text-neutral-200">
                        @if($loop->first)
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                                <polyline points="9 22 9 12 15 12 15 22"/>
                            </svg>
                        @endif
                        {{ $breadcrumb['label'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
@endif