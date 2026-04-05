@forelse($senior_beneficiaries as $senior)
    <tr>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->osca_id_number}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->beneficiary->last_name}} {{$senior->beneficiary->first_name}} </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->age }}
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->format('F d, Y') }}
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->beneficiary->gender}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$senior->beneficiary->address->street->name}}
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$senior->beneficiary->address->street->barangay->name}}
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->beneficiary->employment_status}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->beneficiary->civil_status}}</td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse