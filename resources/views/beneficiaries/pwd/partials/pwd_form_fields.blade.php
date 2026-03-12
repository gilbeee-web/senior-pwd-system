@php
    $isEditingPwd = false;


    if(isset($pwd)){
        $isEditingPwd = true;
    }

@endphp


<div class="w-full flex flex-col gap-y-5">

    <div class="w-full bg-[#C3252B] px-5 py-1">
        <span class="text-white text-xl font-bold">Personal information</span>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">

            <label for="">Last Name:</label>
            <input 
                type="text" 
                placeholder="" 
                name="last_name" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('last_name', $pwd->beneficiary->last_name ?? '') }}"
                required
            >
            @error('last_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>    

        <div class="flex flex-col gap-y-1">

            <label for="">First Name:</label>
            <input 
                type="text" placeholder="" 
                name="first_name" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('first_name', $pwd->beneficiary->first_name ?? '') }}"
                required
            >
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="">Middle Name:</label>
            <input 
                type="text" 
                placeholder="" 
                name="middle_name" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('middle_name', $pwd->beneficiary->middle_name ?? '') }}"
            >
            @error('middle_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="">Suffix (optional):</label>
            <input 
                type="text" placeholder="" 
                name="extension" class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('extension', $pwd->beneficiary->extension ?? '') }}"
            >
            @error('extension')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="birthdate">Date of birth:</label>
            <input 
                type="date" placeholder="" 
                name="birthdate" class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('birthdate', $pwd->beneficiary->birthdate ?? '') }}"
                required
            >
            @error('birthdate')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">
            <label for="contact_number">Contact Number:</label>
            <input 
                type="text" 
                name="contact_number" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('contact_number', $pwd->beneficiary->contact_number ?? '') }}"
                required
            >
            @error('contact_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">

            <label for="gender">Gender:</label>
            <select name="gender" id="" class="border rounded-md py-2 px-5 bg-[#F5F5F5]" required>
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

        
        <div class="flex flex-col gap-y-1">
            <label for="civil_status">Civil Status:</label>

            <select name="civil_status" id="" class="border rounded-md p-2 bg-[#F5F5F5]" required>
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

        <div class="flex flex-col gap-y-1">
            <label for="employment_status">Status of Employment:</label>
            <select name="employment_status" id="" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
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

        <div class="flex flex-col gap-y-1">
            <label for="educational_attainment">Educational Attainment:</label>

            <select name="educational_attainment" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
                @foreach([
                    'None',
                    'Kindergarten',
                    'Elementary',
                    'Junior High School',
                    'Senior High School',
                    'College',
                    'Vocational',
                    'Post Graduate'
                ] as $edu)
                    <option 
                        value="{{ $edu }}"
                        {{ old('educational_attainment', $pwd->educational_attainment ?? '') == $edu ? 'selected' : '' }}
                    >
                        {{ $edu }}
                    </option>
                @endforeach
            </select>

            @error('educational_attainment')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="w-full flex flex-col gap-y-5">

    <div class="w-full bg-[#C3252B] px-5 py-1">
        <span class="text-white text-xl font-bold">Address Information</span>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">
            <label for="house_num">House Number:</label>
            <input 
                type="text" 
                name="house_num" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('house_num', $pwd->beneficiary->address->house_num ?? '') }}"
                required
            >
            @error('house_num')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="barangay_id">Barangay:</label>
            <select 
                name="barangay_id"
                id="barangay"
                class="border rounded-md py-2 px-6 bg-[#F5F5F5]"
                data-street-url="{{ url('beneficiary/streets') }}/"
                required
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

        <div class="flex flex-col gap-y-1">

            <label for="street_id">Street:</label>
            <select name="street_id" id="street" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
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

<div class="w-full flex flex-col gap-y-5">

    <div class="w-full bg-[#C3252B] px-5 py-1">
        <span class="text-white text-xl font-bold">PWD Information</span>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">
            <label for="pwd_id_number">PWD ID Number(RR-PPM-BBB-NNNNNN):</label>

            <input 
                type="text" 
                name="pwd_id_number" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('pwd_id_number', $pwd->pwd_id_number ?? '') }}"
                required
            >

            @error('pwd_id_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">

            <label for="disability_type">Disability Type:</label>
            <select name="disability_type" id="disability_type" class="border rounded-md py-2 px-3 bg-[#F5F5F5]" required>
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

        <div class="flex flex-col gap-y-1">
            <label for="guardian_name">Guardian Name:</label>
            <input 
                type="text" 
                name="guardian_name" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('guardian_name', $pwd->guardian_name ?? '') }}"
                required
            >
            @error('guardian_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="blood_type">Blood Type:</label>
            <select name="blood_type" id="blood_type" class="border rounded-md py-2 px-3 bg-[#F5F5F5]" required>
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
    </div>

    <div>
        @if($isEditingPwd)
            <div class="flex flex-col gap-y-1">
                <label for="date_id_issued">Date ID Issued:</label>
                <input 
                    type="date" 
                    name="date_id_issued" 
                    class="border rounded-md py-2 px-3 bg-[#F5F5F5]"
                    value="{{ old('date_id_issued', $pwd->date_id_issued ?? '') }}"
                >
                @error('date_id_issued')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        @endif
    </div>

</div>

