@forelse($senior_beneficiaries ?? [] as $senior)
    <tr class="border-b hover:bg-gray-200">
        <td class="p-3">{{$senior->osca_id_number}}</td>
        <td class="p-3 uppercase">{{$senior->beneficiary->last_name}} {{$senior->beneficiary->first_name}} </td>
        <td class="p-3">
            <h1>{{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->format('m-d-Y') }}</h1>
        </td>

        <td class="p-3">
            <h1>{{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->age }}</h1>
        </td>

        <td class="p-3 uppercase">{{$senior->beneficiary->gender}}</td>

        <td class="p-3">
            <h1 class="uppercase">{{$senior->beneficiary->address->street->barangay->name}}</h1>
            <p>{{$senior->beneficiary->address->street->name}}</p>
        </td>
        <td class="p-3 uppercase">
            <h1>{{$senior->beneficiary->civil_status}}</h1>
            <p>{{$senior->beneficiary->employment_status ?? 'N/A'}}</p>
        </td>

        @if($senior->beneficiary->life_status === 'deceased' || $senior->beneficiary->residence_status === 'transferred')
            <td class="p-3 space-y-1 flex flex-col">

                {{-- Life Status --}}
                @if($senior->beneficiary->life_status === 'deceased')
                    <span class="px-2 py-1 text-xs rounded bg-gray-500 text-white">
                        Deceased
                    </span>                
                @endif

                {{-- Residency Status --}}
                @if($senior->beneficiary->residence_status === 'transferred')
                    <span class="px-2 py-1 text-xs rounded bg-yellow-500 text-yellow-700">
                        Transferred
                    </span>    
                @endif
            
            </td>
        @else
            <td class="p-3">
                <span class="text-green-500">Active</span>
            </td>
        @endif
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse