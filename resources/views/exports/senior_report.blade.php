<table>
    <thead>
        <tr>
            @if(in_array('osca_id_number', $columns))
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

            @if(in_array('age', $columns))
                <th>Age</th>
            @endif

            @if(in_array('gender', $columns))
                <th>Gender</th>
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
        </tr>
    </thead>

    <tbody>
        @foreach($data as $senior)
            <tr>

                @if(in_array('osca_id_number', $columns))
                    <td>{{ $senior->osca_id_number }}</td>
                @endif

                @if(in_array('name', $columns))
                    <td>{{ $senior->beneficiary->last_name }}</td>
                    <td>{{ $senior->beneficiary->first_name }}</td>
                    <td>{{ $senior->beneficiary->middle_name }}</td>
                    <td>{{ $senior->beneficiary->extension }}</td>
                @endif

                @if(in_array('birthdate', $columns))
                    <td>
                        {{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->format('F d, Y') }}
                    </td>
                @endif

                @if(in_array('age', $columns))
                    <td>
                        {{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->age }}
                    </td>
                @endif

                @if(in_array('gender', $columns))
                    <td>{{ $senior->beneficiary->gender }}</td>
                @endif

                @if(in_array('street', $columns))
                    <td>{{ $senior->beneficiary->address->street->name }}</td>
                @endif

                @if(in_array('barangay', $columns))
                    <td>{{ $senior->beneficiary->address->street->barangay->name }}</td>
                @endif

                @if(in_array('civil_status', $columns))
                    <td>{{ $senior->beneficiary->civil_status }}</td>
                @endif

                @if(in_array('employment_status', $columns))
                    <td>{{ $senior->beneficiary->employment_status }}</td>
                @endif

            </tr>
        @endforeach
    </tbody>
</table>