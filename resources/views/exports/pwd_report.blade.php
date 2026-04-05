<table>
    <thead>
        <tr>
            @if(in_array('pwd_id_number', $columns))
                <th>ID Number</th>
            @endif

            @if(in_array('name', $columns))
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Ext</th>
            @endif

            @if(in_array('birthdate', $columns))
                <th>Birthdate</th>
            @endif

            @if(in_array('gender', $columns))
                <th>Gender</th>
            @endif

            @if(in_array('disability_type', $columns))
                <th>Disability</th>
            @endif

            @if(in_array('street', $columns))
                <th>Street</th>
            @endif

            @if(in_array('barangay', $columns))
                <th>Barangay</th>
            @endif

            @if(in_array('civil_status', $columns))
                <th>Civil Status</th>
            @endif

            @if(in_array('employment_status', $columns))
                <th>Employment Status</th>
            @endif

            @if(in_array('educational_attainment', $columns))
                <th>Educational Attainment</th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach($data as $pwd)

            <tr>

                @if(in_array('pwd_id_number', $columns))
                    <td>{{ $pwd->pwd_id_number }}</td>
                @endif

                @if(in_array('name', $columns))
                    <td>{{ $pwd->beneficiary->last_name }}</td>
                    <td>{{ $pwd->beneficiary->first_name }}</td>
                    <td>{{ $pwd->beneficiary->middle_name }}</td>
                    <td>{{ $pwd->beneficiary->extension }}</td>
                @endif

                @if(in_array('birthdate', $columns))
                    <td>{{ \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('F d, Y') }}</td>
                @endif

                @if(in_array('gender', $columns))
                    <td>{{ $pwd->beneficiary->gender }}</td>
                @endif

                @if(in_array('disability_type', $columns))
                    <td>{{ $pwd->disability_type }}</td>
                @endif

                @if(in_array('street', $columns))
                    <td>{{ $pwd->beneficiary->address->street->name }}</td>
                @endif

                @if(in_array('barangay', $columns))
                    <td> {{ $pwd->beneficiary->address->street->barangay->name }}</td>
                @endif

                @if(in_array('civil_status', $columns))
                    <td>{{ $pwd->beneficiary->civil_status }}</td>
                @endif

                @if(in_array('employment_status', $columns))
                    <td>{{ $pwd->beneficiary->employment_status }}</td>
                @endif

                @if(in_array('educational_attainment', $columns))
                    <td>{{ $pwd->educational_attainment }}</td>
                @endif
            </tr>

        @endforeach
    </tbody>
</table>