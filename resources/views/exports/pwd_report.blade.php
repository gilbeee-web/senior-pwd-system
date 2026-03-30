<table>
    <thead>
        <tr>
            <th>ID number</th>
            <th>Name</th>
            <th>Birthdate</th>
            <th>Gender</th>
            <th>Disability Type</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $pwd)
            <tr>
                <td>{{ $pwd->pwd_id_number }}</td>
                <td>{{ $pwd->beneficiary->last_name }} {{ $pwd->beneficiary->first_name }}</td>
                <td>{{ \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('F d, Y') }}</td>
                <td>{{ $pwd->beneficiary->gender }}</td>
                <td>{{ $pwd->disability_type }}</td>
                <td>{{ $pwd->beneficiary->address->street->name }} {{ $pwd->beneficiary->address->street->barangay->name }}</td>
            </tr>
        @endforeach
    </tbody>
</table>