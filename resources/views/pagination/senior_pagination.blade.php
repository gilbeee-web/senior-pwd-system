<div class="flex flex-col md:flex-row justify-between items-center text-xs mb-10 mt-10 gap-3">

    {{-- Showing X to Y of Z --}}
    
    <div class="text-gray-600">
        Showing {{ $senior_beneficiaries->firstItem() }} to {{ $senior_beneficiaries->lastItem() }} of {{ $senior_beneficiaries->total() }} results
    </div>
    

   
    
    <div class="flex justify-center space-x-2 items-center">

        {{-- First (<<) --}}
        @if ($senior_beneficiaries->currentPage() > 1)
            <a href="{{ $senior_beneficiaries->url(1) }}"
            class="px-3 py-1 border rounded hover:bg-gray-100">
                &laquo;
            </a>
        @else
            <span class="px-3 py-1 border rounded text-gray-400">&laquo;</span>
        @endif

        {{-- Previous (<) --}}
        @if ($senior_beneficiaries->onFirstPage())
            <span class="px-3 py-1 border rounded text-gray-400">&lsaquo;</span>
        @else
            <a href="{{ $senior_beneficiaries->previousPageUrl() }}"
            class="px-3 py-1 border rounded hover:bg-gray-100 font-bold">
                &lsaquo;
            </a>
        @endif

        {{-- Current Page --}}
        <span class="px-4 py-1 border rounded bg-green-700 text-white">
            Page {{ $senior_beneficiaries->currentPage() }} of {{ $senior_beneficiaries->lastPage() }}
        </span>

        {{-- Next (>) --}}
        @if ($senior_beneficiaries->hasMorePages())
            <a href="{{ $senior_beneficiaries->nextPageUrl() }}"
            class="px-3 py-1 border rounded hover:bg-gray-100">
                &rsaquo;
            </a>
        @else
            <span class="px-3 py-1 border rounded text-gray-400">&rsaquo;</span>
        @endif

        {{-- Last (>>) --}}
        @if ($senior_beneficiaries->currentPage() < $senior_beneficiaries->lastPage())
            <a href="{{ $senior_beneficiaries->url($senior_beneficiaries->lastPage()) }}"
            class="px-3 py-1 border rounded hover:bg-gray-100">
                &raquo;
            </a>
        @else
            <span class="px-3 py-1 border rounded text-gray-400">&raquo;</span>
        @endif

    </div>

</div>