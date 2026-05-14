
@forelse($pwd_beneficiaries ?? [] as $pwd)
    <tr class="border-b hover:bg-gray-200">
        <td class="p-3">
            <h1>{{$pwd->pwd_id_number}}</h1>
            <p class="uppercase">{{$pwd->disability_type}}</p>
        </td>
        <td class="p-3 uppercase">
            <h1>{{$pwd->beneficiary->first_name}} {{$pwd->beneficiary->middle_name ?? ' '}} {{$pwd->beneficiary->last_name}} </h1>
            <p>{{$pwd->beneficiary->gender}}</p> 
        </td>
        <td class="p-3 uppercase">
            {{ \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('m-d-Y') }}
        </td>

        <td class="p-3">
            <h1 class="uppercase">{{$pwd->beneficiary->address->street->barangay->name}}</h1>
            <p>{{$pwd->beneficiary->address->street->name}} </p>
            
        </td>

        <td class="p-3 uppercase">
            <h1>{{$pwd->beneficiary->civil_status}}</h1>
            <p>{{$pwd->beneficiary->employment_status ?? 'N/A'}}</p>
        </td>
        <td class="p-3 uppercase">{{$pwd->educational_attainment}}</td>
        <td class="p-3 space-y-1 flex flex-col">

            {{-- Life Status --}}
            @if($pwd->beneficiary->life_status === 'alive')
                <p class="px-2 py-1 text-xs rounded text-green-700">
                    Alive
                </p>
            @else
                <span class="px-2 py-1 text-xs rounded bg-gray-500 text-white">
                    Deceased
                </span>
            @endif


            {{-- Residency Status --}}
            @if($pwd->beneficiary->residence_status === 'active')
                <p class="px-2 py-1 text-xs rounded text-blue-700">
                    Active Resident
                </p>
            @else
                <span class="px-2 py-1 text-xs rounded bg-yellow-500 text-yellow-700">
                    Transferred
                </span>
            @endif
         
            @if($pwd->is_middleclass === 1)
                <p class="px-2 py-1 text-xs rounded bg-purple-500 text-white">
                    Middle Class
                </p>
            @endif
            
          

        </td>

    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse