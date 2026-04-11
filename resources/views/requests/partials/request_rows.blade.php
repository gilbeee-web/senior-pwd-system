@forelse($requests as $request)
    <tr>
        <td class="px-4 py-2 text-gray-800 border">{{ $request->id }}</td>
        <td class="px-4 py-2 text-gray-800 border">{{ ucfirst($request->type) }}</td>

        {{-- Model Type --}}
        <td class="px-4 py-2 text-gray-800 border">
            @if($request->model_type === App\Models\SeniorDetail::class)
                Senior
            @elseif($request->model_type === App\Models\PwdDetail::class)
                PWD
            @else
                Unknown
            @endif
        </td>

        {{-- Record Name --}}
        <td class="px-4 py-2 text-gray-800 border">
            @php
                $model = $request->model_type::find($request->model_id);
            @endphp
            @if($model)
                {{ $model->beneficiary->last_name ?? ' ' }} {{ $model->beneficiary->first_name ?? ' ' }} {{ $model->beneficiary->middle_name ?? ' ' }}
            @else
                N/A
            @endif
        </td>

        {{-- Requested By --}}
        <td class="px-4 py-2 text-gray-800 border">
            {{ $request->requester->name ?? 'Unknown' }}
        </td>

        {{-- Date --}}
        <td class="px-4 py-2 text-gray-800 border">
            {{ $request->created_at->format('M d, Y H:i') }}
        </td>

        {{-- Status --}}
        <td class="px-4 py-2 text-gray-800 border capitalize">
            {{ $request->status }}
        </td>

        {{-- Actions --}}
        <td class="px-4 py-2 text-gray-800 border">
            @if($request->status === 'pending')
                <button 
                    class="action-btn text-blue-600 hover:underline"
                    data-id="{{$request->id}}"
                    data-type="{{$request->type}}"
                    data-old='@json($request->model)'
                    data-new='@json($request->payload)'
                >
                    Approve
                </a>
            @else
                <button 
                    class="action-btn text-gray-500 hover:underline"
                    data-id="{{$request->id}}"
                    data-type="{{$request->type}}"
                >
                    View
                </a>
            @endif
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-4 text-gray-500 text-[24px] font-bold">
            No requests found.
        </td>
    </tr>
@endforelse