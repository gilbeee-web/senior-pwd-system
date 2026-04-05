
@forelse($pwd_beneficiaries as $pwd)
    <tr>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->pwd_id_number}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->last_name}} {{$pwd->beneficiary->first_name}} </td>
        {{-- <td class="px-4 py-2 text-sm text-gray-800 border">{{ \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('F d, Y') }}</td> --}}
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->gender}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->disability_type}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$pwd->beneficiary->address->street->name}} 
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$pwd->beneficiary->address->street->barangay->name}}
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->employment_status}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->civil_status}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->educational_attainment}}</td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse