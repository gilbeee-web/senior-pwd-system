@forelse($requests as $request)
    <tr class="border-b hover:bg-gray-200">

        <td class="p-3">
            <h1 class="uppercase font-semibold">
                @php
                $model = $request->model_type::find($request->model_id);
                @endphp
                @if($model && $request->type === 'update')
                    {{ $model->beneficiary->last_name ?? ' ' }} {{ $model->beneficiary->first_name ?? ' ' }} {{ $model->beneficiary->middle_name ?? ' ' }}
                @elseif($request->type ==='archive')
                    {{ $request->payload['beneficiary_name'] ?? 'N/A' }}
                @else
                    N/A
                @endif
            </h1>

            <p>
                @if($request->model_type === App\Models\SeniorDetail::class)
                    Senior
                @elseif($request->model_type === App\Models\PwdDetail::class)
                    PWD
                @else
                    Unknown
                @endif
            </p>
        </td>

        <td class="p-3 uppercase">{{ ucfirst($request->type) }}</td>

        {{-- Requested By --}}
        <td class="p-3">
            <h1 class="uppercase font-semibold">{{ $request->requester->name ?? 'Unknown' }}</h1>
            <p>{{ ucwords(str_replace('_', ' ', $request->requester->role)) }}</p>
        </td>

        {{-- Status --}}
        <td class="p-3 uppercase">
            {{ $request->status }}
        </td>

        {{-- Date --}}
        <td class="p-3">
            {{ \Carbon\Carbon::parse($request->created_at)->format('m-d-Y') }}
        </td>

        {{-- Actions --}}
        <td class="p-3">
            @if($request->status === 'pending')
                <button 
                    class="action-btn bg-green-500 text-white rounded-lg p-2 border hover:bg-green-400 cursor-pointer"
                    data-id="{{$request->id}}"
                    data-type="{{$request->type}}"
                    data-old='@json($request->model)'
                    data-new='@json($request->payload)'
                >
                    Approve
                </a>
            @else
                <button 
                    class="action-btn bg-gray-500 p-2 hover:underline cursor-pointer"
                    data-id="{{$request->id}}"
                    data-old='@json($request->model)'
                    data-new='@json($request->payload)'
                    data-type="view"
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