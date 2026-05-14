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

    <div class="grid grid-cols-5 gap-6 px-5">

        <div class="flex flex-col gap-y-1">

            <label for="">Last Name: <span class="text-red-500">*</span></label>
            <input 
                type="text" 
                placeholder="" 
                name="last_name" 
                class="border rounded-md p-2 bg-[#F5F5F5] uppercase"
                value="{{ old('last_name', $pwd->beneficiary->last_name ?? '') }}"
                required
            >
            @error('last_name')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>    

        <div class="flex flex-col gap-y-1">

            <label for="">First Name: <span class="text-red-500">*</span></label>
            <input 
                type="text" placeholder="" 
                name="first_name" 
                class="border rounded-md p-2 bg-[#F5F5F5] uppercase"
                value="{{ old('first_name', $pwd->beneficiary->first_name ?? '') }}"
                required
            >
            @error('first_name')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="">Middle Name:</label>
            <input 
                type="text" 
                placeholder="" 
                name="middle_name" 
                class="border rounded-md p-2 bg-[#F5F5F5] uppercase"
                value="{{ old('middle_name', $pwd->beneficiary->middle_name ?? '') }}"
            >
            @error('middle_name')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="">Suffix:</label>
            <input 
                type="text" placeholder="" 
                name="extension" class="border rounded-md p-2 bg-[#F5F5F5] uppercase"
                value="{{ old('extension', $pwd->beneficiary->extension ?? '') }}"
            >
            @error('extension')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="birthdate">Date of birth: <span class="text-red-500">*</span></label>
            <input 
                type="date"
                name="birthdate" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('birthdate', isset($pwd->beneficiary->birthdate) 
                    ? \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('Y-m-d') 
                    : '') }}"
                required
            >
            @error('birthdate')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>
    </div>

    <div class="grid grid-cols-5 gap-6 px-5">

        <div class="flex flex-col gap-y-1">
            <label for="contact_number">Contact Number: <span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="contact_number" 
                class="border rounded-md p-2 bg-[#F5F5F5] uppercase"
                value="{{ old('contact_number', $pwd->beneficiary->contact_number ?? '') }}"
                required
            >
            @error('contact_number')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">

            <label for="gender">Gender: <span class="text-red-500">*</span></label>
            <select name="gender" id="" class="border rounded-md py-2 px-5 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                <option 
                    value="male" 
                    {{ old('gender', $pwd->beneficiary->gender ?? '') == 'male' ? 'selected' : '' }}
                >
                    Male
                </option>

                <option 
                    value="female" 
                    {{ old('gender', $pwd->beneficiary->gender ?? '') == 'female' ? 'selected' : '' }}
                >
                    Female
                </option>
            </select>
            @error('gender')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="flex flex-col gap-y-1">
            <label for="civil_status">Civil Status: <span class="text-red-500">*</span></label>

            <select name="civil_status" id="" class="border rounded-md p-2 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                <option 
                    value="single" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'single' ? 'selected' : '' }}
                >
                   Single
                </option>
                <option 
                    value="married" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'married' ? 'selected' : '' }}
                >
                   Married
                </option>
                <option 
                    value="widowed" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'widowed' ? 'selected' : '' }}
                >
                   Widow/er
                </option>
                <option 
                    value="separated" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'separated' ? 'selected' : '' }}
                >
                   Separated
                </option>
                <option 
                    value="cohabitation (live-in)" 
                    {{ old('civil_status', $pwd->beneficiary->civil_status ?? '') == 'cohabitation (live-in)' ? 'selected' : '' }}
                >
                   Cohabitation (live-in)
                </option>
            </select>
            @error('civil_status')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="employment_status">Status of Employment: <span class="text-red-500">*</span></label>
            <select name="employment_status" id="" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                <option 
                    value="employed" 
                    {{ old('employment_status', $pwd->beneficiary->employment_status ?? '') == 'employed' ? 'selected' : '' }}
                >
                   Employed
                </option>

                <option 
                    value="unemployed" 
                    {{ old('employment_status', $pwd->beneficiary->employment_status ?? '') == 'unemployed' ? 'selected' : '' }}
                >
                   Unemployed
                </option>

                <option 
                    value="self_employed" 
                    {{ old('employment_status', $pwd->beneficiary->employment_status ?? '') == 'self_employed' ? 'selected' : '' }}
                >
                   Self-employed
                </option>

            </select>
            @error('employment_status')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="educational_attainment">Educational Attainment: <span class="text-red-500">*</span></label>

            <select name="educational_attainment" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
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
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>

<div class="w-full flex flex-col gap-y-5">

    <div class="w-full bg-[#C3252B] px-5 py-1">
        <span class="text-white text-xl font-bold">Address Information</span>
    </div>

    <div class="grid grid-cols-5 gap-6 px-5">

        <div class="flex flex-col gap-y-1">
            <label for="house_num">House Number: <span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="house_num" 
                class="border rounded-md p-2 bg-[#F5F5F5] uppercase" 
                value="{{ old('house_num', $pwd->beneficiary->address->house_num ?? '') }}"
                required
            >
            @error('house_num')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="barangay_id">Barangay: <span class="text-red-500">*</span></label>

            @if($current_user->role === 'barangay_pwd_admin')
                <select 
                    name="barangay_id"
                    id="pwd_barangay"
                    class="border rounded-md py-2 px-6 bg-[#F5F5F5]"
                    data-street-url="{{ url('beneficiary/streets') }}/"
                    required
                >
                    <option value="" disabled hidden>Select</option>
                    <option value="{{$current_user_brgy->id}}">{{ $current_user_brgy->name }}</option>
                </select>
            @else
                <select 
                    name="barangay_id"
                    id="pwd_barangay"
                    class="border rounded-md py-2 px-6 bg-[#F5F5F5]"
                    data-street-url="{{ url('beneficiary/streets') }}/"
                    required
                >
                    <option value="" disabled selected hidden>Select</option>

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
            @endif
            @error('barangay_id')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">

            <label for="street_id">Street: <span class="text-red-500">*</span></label>
            <select name="street_id" id="pwd_street" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
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
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>
    </div>
</div>

<div class="w-full flex flex-col gap-y-5">

    <div class="w-full bg-[#C3252B] px-5 py-1">
        <span class="text-white text-xl font-bold">PWD Information</span>
    </div>

    <div class="grid grid-cols-4 gap-6 px-5">

        <div class="flex flex-col gap-y-1">
            <label for="pwd_id_number">PWD ID Number: <span class="text-red-500">*</span></label>

            <input 
                type="text" 
                name="pwd_id_number" 
                class="border rounded-md p-2 bg-[#F5F5F5] uppercase"
                value="{{ old('pwd_id_number', $pwd->pwd_id_number ?? '') }}"
                required
            >

            @error('pwd_id_number')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">

            <label for="disability_type">Disability Type: <span class="text-red-500">*</span></label>
            <select name="disability_type" id="disability_type" class="border rounded-md py-2 px-3 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                @foreach([
                    'Deaf or Hard of Hearing',
                    'Intellectual',
                    'Learning',
                    'Mental',
                    'Physical(Orthophedic)',
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
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">
            <label for="guardian_name">Guardian Name: <span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="guardian_name" 
                class="border rounded-md p-2 bg-[#F5F5F5] uppercase"
                value="{{ old('guardian_name', $pwd->guardian_name ?? '') }}"
                required
            >
            @error('guardian_name')
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="blood_type">Blood Type: <span class="text-red-500">*</span></label>
            <select name="blood_type" id="blood_type" class="border rounded-md py-2 px-3 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                @foreach([
                    'O',
                    'O-',
                    'A',
                    'A-',
                    'B',
                    'B-',
                    'AB',
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
                <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
            @enderror

        </div>

        
        @if($isEditingPwd)
            <div class="flex flex-col gap-y-1">
                <label for="date_id_issued">Date ID Issued:</label>
                <input 
                    type="date" 
                    name="date_id_issued" 
                    class="border rounded-md py-2 px-3 bg-[#F5F5F5]"
                    {{-- value="{{ old('date_id_issued', $pwd->date_id_issued ?? '') }}" --}}
                    value="{{ old('date_id_issued', \Carbon\Carbon::parse($pwd->date_id_issued ?? '')->format('Y-m-d')) }}"
                >
                @error('date_id_issued')
                    <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
                @enderror
            </div>
        @endif
        
    </div>

    <div class="w-[90%] flex flex-col gap-y-1 px-5">
        <label for="qr_link">QR Link: <span class="text-red-500">*</span></label>
        <input 
            type="text" 
            name="qr_link" 
            class="border rounded-md p-2 bg-[#F5F5F5]"
            value="{{ old('qr_link', $pwd->qr_link ?? '') }}"
            required
        >
        @error('qr_link')
            <p class="text-red-500 text-sm min-h-[1.25rem]">{{ $message }}</p>
        @enderror
    </div>


</div>

