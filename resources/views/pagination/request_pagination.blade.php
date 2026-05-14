<div class="flex flex-col md:flex-row justify-between items-center text-xs mb-10 mt-10 gap-3">

    {{-- Showing X to Y of Z --}}
    <div class="text-gray-600">
        Showing {{ $requests->firstItem() }} to {{ $requests->lastItem() }} of {{ $requests->total() }} results
    </div>

    <div class="flex justify-center space-x-2 items-center">

        {{-- First (<<) --}}
        @if ($requests->currentPage() > 1)
            <a href="{{ $requests->url(1) }}"
            class="px-3 py-1 border rounded hover:bg-gray-100">
                &laquo;
            </a>
        @else
            <span class="px-3 py-1 border rounded text-gray-400">&laquo;</span>
        @endif

        {{-- Previous (<) --}}
        @if ($requests->onFirstPage())
            <span class="px-3 py-1 border rounded text-gray-400">&lsaquo;</span>
        @else
            <a href="{{ $requests->previousPageUrl() }}"
            class="px-3 py-1 border rounded hover:bg-gray-100 font-bold">
                &lsaquo;
            </a>
        @endif

        {{-- Current Page --}}
        <span class="px-4 py-1 border rounded bg-green-700 text-white">
            Page {{ $requests->currentPage() }} of {{ $requests->lastPage() }}
        </span>

        {{-- Next (>) --}}
        @if ($requests->hasMorePages())
            <a href="{{ $requests->nextPageUrl() }}"
            class="px-3 py-1 border rounded hover:bg-gray-100">
                &rsaquo;
            </a>
        @else
            <span class="px-3 py-1 border rounded text-gray-400">&rsaquo;</span>
        @endif

        {{-- Last (>>) --}}
        @if ($requests->currentPage() < $requests->lastPage())
            <a href="{{ $requests->url($requests->lastPage()) }}"
            class="px-3 py-1 border rounded hover:bg-gray-100">
                &raquo;
            </a>
        @else
            <span class="px-3 py-1 border rounded text-gray-400">&raquo;</span>
        @endif

    </div>

</div>