<div class="flex flex-col md:flex-row justify-between items-center text-xs mb-10 mt-10 gap-3">

    {{-- Showing X to Y of Z --}}
    <div class="text-gray-600">
        Showing {{ $senior_beneficiaries->firstItem() }} to {{ $senior_beneficiaries->lastItem() }} of {{ $senior_beneficiaries->total() }} results
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center space-x-2">
        @foreach ($senior_beneficiaries->links()->elements as $element)
            {{-- "Three dots" separator --}}
            @if (is_string($element))
                <span class="px-3 py-1 border rounded text-gray-400">
                    {{ $element }}
                </span>
            @endif

            {{-- Page links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $senior_beneficiaries->currentPage())
                        <span class="px-3 py-1 border rounded bg-green-700 text-white">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-1 border rounded hover:bg-gray-100">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>

</div>