{{-- @php
    $isEditingPwd = false;


    if(isset($pwd)){
        $isEditingPwd = true;
    }

@endphp


<div class="flex flex-col gap-y-3">

    <h1 class="text-xl font-bold">Personal Infomation</h1>

    <div class="flex gap-x-5">

        <div class="mt-3 flex flex-col gap-y-1">
            <label for="">Last Name:</label>
            <input 
                type="text" 
                placeholder="" 
                name="last_name" 
                class="border rounded p-2"
                value="{{ old('last_name', $pwd->beneficiary->last_name ?? '') }}"
            >
            @error('last_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-3 flex flex-col gap-y-1">

            <label for="">First Name:</label>
            <input 
                type="text" placeholder="" 
                name="first_name" class="border rounded p-2"
                value="{{ old('first_name', $pwd->beneficiary->first_name ?? '') }}"
            >
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>


        <div class="mt-3 flex flex-col gap-y-1">

            <label for="">Middle Name:</label>
            <input 
                type="text" 
                placeholder="" 
                name="middle_name" 
                class="border rounded p-2"
                value="{{ old('middle_name', $pwd->beneficiary->middle_name ?? '') }}"
            >
            @error('middle_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="mt-3 flex flex-col gap-y-1">

            <label for="">Suffix (optional):</label>
            <input 
                type="text" placeholder="" 
                name="extension" class="border rounded p-2"
                value="{{ old('extension', $pwd->beneficiary->extension ?? '') }}"
            >
            @error('extension')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>
    </div>

    <div class="flex gap-x-5">

        <div class="mt-3 flex flex-col gap-y-1">

            <label for="birthdate">Date of birth</label>
            <input 
                type="date" placeholder="" 
                name="birthdate" class="border rounded p-2"
                value="{{ old('birthdate', $pwd->beneficiary->birthdate ?? '') }}"
            >
            @error('birthdate')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="mt-3 flex flex-col gap-y-1">

            <label for="birthdate">Place of birth:</label>
            <input 
                type="text" placeholder="" 
                name="place_of_birth" class="border rounded p-2"
                value=""
            >
            @error('place_of_birth')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="mt-3 flex flex-col gap-y-1">

            <label for="gender">Gender:</label>
            <select name="gender" id="" class="border rounded p-2">
                <option 
                    value="Male" 
                    {{ old('gender', $pwd->beneficiary->gender ?? '') == 'Male' ? 'selected' : '' }}
                >
                    Male
                </option>

                <option 
                    value="Female" 
                    {{ old('gender', $pwd->beneficiary->gender ?? '') == 'Female' ? 'selected' : '' }}
                >
                    Female
                </option>
            </select>
            @error('gender')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="mt-3 flex flex-col gap-y-1">
            <label for="employment_status">Status of Employment:</label>
            <select name="employment_status" id="" class="border rounded p-2">
                <option 
                    value="Employed" 
                    {{ old('employment_status', $pwd->beneficiary->employment_status ?? '') == 'Employed' ? 'selected' : '' }}
                >
                   Employed
                </option>

                <option 
                    value="Unemployed" 
                    {{ old('employment_status', $pwd->beneficiary->employment_status ?? '') == 'Unemployed' ? 'selected' : '' }}
                >
                   Unemployed
                </option>

                <option 
                    value="Self-employed" 
                    {{ old('employment_status', $pwd->beneficiary->employment_status ?? '') == 'Self-employed' ? 'selected' : '' }}
                >
                   Self-employed
                </option>

            </select>
            @error('employment_status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-3 flex flex-col gap-y-1">
            <label for="civil_status">Civil Status:</label>

            <select name="civil_status" id="" class="border rounded p-2">
                <option 
                    value="Single" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'Single' ? 'selected' : '' }}
                >
                   Single
                </option>
                <option 
                    value="Married" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'Married' ? 'selected' : '' }}
                >
                   Married
                </option>
                <option 
                    value="Widow/er" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'Widow/er' ? 'selected' : '' }}
                >
                   Widow/er
                </option>
                <option 
                    value="Separated" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'Separated' ? 'selected' : '' }}
                >
                   Separated
                </option>
                <option 
                    value="Cohabitation (live-in)" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'Cohabitation (live-in)' ? 'selected' : '' }}
                >
                   Cohabitation (live-in)
                </option>
            </select>
            @error('civil_status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-3 flex flex-col gap-y-1">
            <label for="contact_number">Contact Number</label>
            <input 
                type="text" 
                name="contact_number" 
                class="border rounded p-2"
                value="{{ old('contact_number', $pwd->beneficiary->contact_number ?? '') }}"
            >
            @error('contact_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>
</div>


<div class="flex flex-col mt-5">

    <h1 class="text-xl font-bold">Address information</h1>

    <div class="flex flex gap-x-3">
        <div class="mt-3 flex flex-col gap-y-1">
            <label for="house_num">House Number</label>
            <input 
                type="text" 
                name="house_num" 
                class="border rounded p-2"
                value="{{ old('house_num', $pwd->beneficiary->address->house_num ?? '') }}"
            >
            @error('house_num')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-3 flex flex-col gap-y-1">
            <label for="barangay_id">Barangay</label>
            <select 
                name="barangay_id"
                id="barangay"
                class="border rounded px-3 py-2"
                data-street-url="{{ url('beneficiary/streets') }}/"
            >
                <option value="">-- Select Barangay --</option>

                @foreach($barangays as $brgy)
                    <option 
                        value="{{ $brgy->id }}"
                        {{ 
                            old('barangay_id', $pwd->beneficiary->address->street->barangay->id ?? '') == $brgy->id ? 'selected' : '' 
                        }}
                    >
                        {{ $brgy->name }}
                    </option>
                @endforeach
            </select>
            @error('barangay_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mt-3 flex flex-col gap-y-1">

            <label for="street_id">Street</label>
            <select name="street_id" id="street" class="border rounded p-2">
                <option value="">Select Street</option>
                @if($isEditingPwd)
                    @foreach($streets as $street)
                        <option 
                            value="{{ $street->id }}"
                            {{ 
                                old('street_id', $pwd->beneficiary->address->street_id ?? '') == $street->id 
                                ? 'selected' : '' 
                            }}
                        >
                            {{ $street->name }}
                        </option>
                    @endforeach
                @endif
            </select>

            @error('street_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>
    </div>
    

</div>

<div class="flex flex-col">
    
    <h1 class="text-xl font-bold">Senior Information</h1>

    <div class="mt-3 flex flex-col gap-y-1">
        <label for="pwd_id_number">OSCA ID Number:</label>

        <input 
            type="text" 
            name="osca_id_number" 
            class="border rounded p-2"
            value="{{ old('osca_id_number', $pwd->pwd_id_number ?? '') }}"
        >

        @error('osca_id_number')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-3 flex flex-col gap-y-1">
        <label for="guardian_name">Guardian Name:</label>
        <input 
            type="text" 
            name="guardian_name" 
            class="border rounded p-2"
            value="{{ old('guardian_name', $pwd->guardian_name ?? '') }}"
        >
        @error('guardian_name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mt-3 flex flex-col gap-y-1">

        <label for="disability_type">Disability Type</label>
        <select name="disability_type" id="disability_type" class="border rounded p-2">
            @foreach([
                'Deaf or Hard of Hearing',
                'Intellectual',
                'Learning',
                'Mental',
                'Physical',
                'Psychosocial',
                'Speech and Language Impairment',
                'Visual',
                'Cancer(RA11215)',
                'Rare Disease'
            ] as $disability)

                <option 
                    value="{{ $disability }}"
                    {{ old('disability_type', $pwd->disability_type ?? '') == $disability ? 'selected' : '' }}
                >
                    {{ $disability }}
                </option>
            @endforeach
        </select>
        

        @error('disability_type')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>

    <div class="mt-3 flex flex-col gap-y-1">

        <label for="blood_type">Blood Type</label>
        <select name="blood_type" id="blood_type" class="border rounded p-2">
            @foreach([
                'O+',
                'O-',
                'A+',
                'A-',
                'B+',
                'B-',
                'AB+',
                'AB-',
                'Unknown'
            ] as $blood_type)

                <option 
                    value="{{ $blood_type }}"
                    {{ old('blood_type', $pwd->blood_type ?? '') == $blood_type ? 'selected' : '' }}
                >
                    {{ $blood_type }}
                </option>
            @endforeach
        </select>

        @error('blood_type')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>

    <div class="mt-3 flex flex-col gap-y-1">
        <label for="date_id_issued">Date ID issued:</label>
        <input 
            type="date" 
            name="date_id_issued" 
            class="border rounded p-2"
            value="{{ old('date_id_issued', $pwd->date_id_issued ?? '') }}"
        >
        @error('date_id_issued')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
</div> --}}
