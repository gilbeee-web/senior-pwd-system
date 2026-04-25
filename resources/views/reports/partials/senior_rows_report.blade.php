@forelse($senior_beneficiaries as $senior)
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
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse