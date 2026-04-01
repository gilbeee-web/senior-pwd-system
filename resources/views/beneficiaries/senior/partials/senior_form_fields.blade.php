@php
    $isEditingSenior = false;


    if(isset($senior)){
        $isEditingSenior = true;
    }

@endphp


<div class="w-full flex flex-col gap-y-5">

    <div class="w-full bg-[#C3252B] px-5 py-1">
        <span class="text-white text-xl font-bold">Personal information</span>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">

            <label for="">Last Name: <span class="text-red-500">*</span></label>
            <input 
                type="text" 
                placeholder="" 
                name="last_name" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('last_name', $senior->beneficiary->last_name ?? '') }}"
                required
            >
            @error('last_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>    

        <div class="flex flex-col gap-y-1">

            <label for="">First Name:<span class="text-red-500">*</span></label>
            <input 
                type="text" placeholder="" 
                name="first_name" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('first_name', $senior->beneficiary->first_name ?? '') }}"
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
                value="{{ old('middle_name', $senior->beneficiary->middle_name ?? '') }}"
            >
            @error('middle_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="">Suffix:</label>
            <input 
                type="text" placeholder="" 
                name="extension" class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('extension', $senior->beneficiary->extension ?? '') }}"
            >
            @error('extension')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>

        <div class="flex flex-col gap-y-1">

            <label for="birthdate">Date of birth:<span class="text-red-500">*</span></label>
            <input 
                type="date" placeholder="" 
                name="birthdate" class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('birthdate', $senior->beneficiary->birthdate ?? '') }}"
                required
            >
            @error('birthdate')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

        </div>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">
            <label for="contact_number">Contact Number:<span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="contact_number" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('contact_number', $senior->beneficiary->contact_number ?? '') }}"
                required
            >
            @error('contact_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">

            <label for="gender">Gender:<span class="text-red-500">*</span></label>
            <select name="gender" id="" class="border rounded-md py-2 px-5 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                <option 
                    value="Male" 
                    {{ old('gender', $senior->beneficiary->gender ?? '') == 'Male' ? 'selected' : '' }}
                >
                    Male
                </option>

                <option 
                    value="Female" 
                    {{ old('gender', $senior->beneficiary->gender ?? '') == 'Female' ? 'selected' : '' }}
                >
                    Female
                </option>
            </select>
            @error('gender')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="flex flex-col gap-y-1">
            <label for="civil_status">Civil Status:<span class="text-red-500">*</span></label>

            <select name="civil_status" id="" class="border rounded-md p-2 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                <option 
                    value="Single" 
                    {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Single' ? 'selected' : '' }}
                >
                   Single
                </option>
                <option 
                    value="Married" 
                    {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Married' ? 'selected' : '' }}
                >
                   Married
                </option>
                <option 
                    value="Widow/er" 
                    {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Widow/er' ? 'selected' : '' }}
                >
                   Widow/er
                </option>
                <option 
                    value="Separated" 
                    {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Separated' ? 'selected' : '' }}
                >
                   Separated
                </option>
                <option 
                    value="Cohabitation (live-in)" 
                    {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Cohabitation (live-in)' ? 'selected' : '' }}
                >
                   Cohabitation (live-in)
                </option>
            </select>
            @error('civil_status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="employment_status">Status of Employment:<span class="text-red-500">*</span></label>
            <select name="employment_status" id="" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>
                <option 
                    value="Employed" 
                    {{ old('employment_status', $senior->beneficiary->employment_status ?? '') == 'Employed' ? 'selected' : '' }}
                >
                   Employed
                </option>

                <option 
                    value="Unemployed" 
                    {{ old('employment_status', $senior->beneficiary->employment_status ?? '') == 'Unemployed' ? 'selected' : '' }}
                >
                   Unemployed
                </option>

                <option 
                    value="Self-employed" 
                    {{ old('employment_status', $senior->beneficiary->employment_status ?? '') == 'Self-employed' ? 'selected' : '' }}
                >
                   Self-employed
                </option>

            </select>
            @error('employment_status')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- <div class="flex flex-col gap-y-1">
            <label for="educational_attainment">Educational Attainment:<span class="text-red-500">*</span></label>

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
                        {{ old('educational_attainment', $senior->educational_attainment ?? '') == $edu ? 'selected' : '' }}
                    >
                        {{ $edu }}
                    </option>
                @endforeach
            </select>

            @error('educational_attainment')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div> --}}
    </div>
</div>

<div class="w-full flex flex-col gap-y-5">

    <div class="w-full bg-[#C3252B] px-5 py-1">
        <span class="text-white text-xl font-bold">Address Information</span>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">
            <label for="house_num">House Number:<span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="house_num" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('house_num', $senior->beneficiary->address->house_num ?? '') }}"
                required
            >
            @error('house_num')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="barangay_id">Barangay:<span class="text-red-500">*</span></label>
            <select 
                name="barangay_id"
                id="barangay"
                class="border rounded-md py-2 px-6 bg-[#F5F5F5]"
                data-street-url="{{ url('beneficiary/streets') }}/"
                required
            >
                <option value="" disabled selected hidden>Select</option>

                @foreach($barangays as $brgy)
                    <option 
                        value="{{ $brgy->id }}"
                        {{ 
                            old('barangay_id', $senior->beneficiary->address->street->barangay->id ?? '') == $brgy->id ? 'selected' : '' 
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

            <label for="street_id">Street:<span class="text-red-500">*</span></label>
            <select name="street_id" id="street" class="border rounded-md py-2 px-6 bg-[#F5F5F5]" required>
                <option value="" disabled selected hidden>Select</option>

                {{-- pre define the street if editing mode  --}}
                @if($isEditingSenior)
                    @foreach($streets as $street)
                        <option 
                            value="{{ $street->id }}"
                            {{ 
                                old('street_id', $senior->beneficiary->address->street_id ?? '') == $street->id 
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
        <span class="text-white text-xl font-bold">Senior Information</span>
    </div>

    <div class="flex gap-x-10 items-center px-5">

        <div class="flex flex-col gap-y-1">
            <label for="osca_id_number">OSCA ID Number:<span class="text-red-500">*</span></label>

            <input 
                type="text" 
                name="osca_id_number" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('osca_id_number', $senior->osca_id_number ?? '') }}"
                required
            >

            @error('osca_id_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="ncsc_registration_number">NCSC Registration Number:</label>

            <input 
                type="text" 
                name="ncsc_registration_number" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('ncsc_registration_number', $senior->ncsc_registration_number ?? '') }}"
            >

            @error('ncsc_registration_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        
        <div class="flex flex-col gap-y-1">
            <label for="place_of_birth">Place of Birth:<span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="place_of_birth" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('place_of_birth', $senior->place_of_birth ?? '') }}"
                required
            >
            @error('place_of_birth')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex flex-col gap-y-1">
            <label for="occupation">Occupation:<span class="text-red-500">*</span></label>
            <input 
                type="text" 
                name="occupation" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('occupation', $senior->occupation ?? '') }}"
                required
            >
            @error('occupation')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

    </div>

    <div class="flex flex-col gap-y-3 justify-center px-5">

        <div class="flex gap-x-3 items-center">
            <input 
                type="checkbox"  
                class="h-5 w-5" 
                id="has_pension"
                {{ old('pension_amount', $senior->pension_amount ?? null) ? 'checked' : '' }}
            >
            <label for="">is receiving pension?</label>
        </div>

        <div class="flex flex-col gap-y-1 w-[15%] hidden" id="pensionAmount-wrapper">
            <label for="pension_amount">Pension Amount:</label>
            <input 
                type="text" 
                name="pension_amount" 
                class="border rounded-md p-2 bg-[#F5F5F5]"
                value="{{ old('pension_amount', $senior->pension_amount ?? '') }}"
            >
            @error('pension_amount')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex flex-col gap-y-3 justify-center">

        <!-- CHECKBOX -->
        <div class="flex gap-x-3 items-center px-5">
            <input type="checkbox" id="with_family" class="h-5 w-5">
            <label>staying with family?</label>
        </div>

        <!-- FAMILY CONTAINER -->
        <div id="family-container" class="flex flex-col gap-y-3 justify-center items-center hidden">

            <!-- TEMPLATE -->
            <template id="family-template">
                <div class="family-item flex gap-x-3 items-center justify-center bg-gray-300 rounded-lg p-3 w-[97%] relative">

                    <!-- REMOVE BUTTON -->
                    <button type="button"
                        class="remove-family absolute top-2 right-2 text-red-500 font-bold text-lg">
                        ✕
                    </button>

                    <input type="hidden" data-name="id">

                    <!-- FULL NAME -->
                    <div class="flex flex-col gap-y-1">
                        <label>Full Name:<span class="text-red-500">*</span></label>
                        <input type="text"
                            class="border rounded-md p-2 bg-[#F5F5F5]"
                            data-name="full_name"
                            required>
                    </div>

                    <!-- RELATIONSHIP -->
                    <div class="flex flex-col gap-y-1">
                        <label>Relationship:<span class="text-red-500">*</span></label>
                        <input type="text"
                            class="border rounded-md p-2 bg-[#F5F5F5]"
                            data-name="relationship"
                            required>
                    </div>

                    <!-- BIRTHDATE -->
                    <div class="flex flex-col gap-y-1">
                        <label>Date of birth:<span class="text-red-500">*</span></label>
                        <input type="date"
                            class="border rounded-md p-2 bg-[#F5F5F5]"
                            data-name="birthdate"
                            required>
                    </div>

                    <!-- OCCUPATION -->
                    <div class="flex flex-col gap-y-1">
                        <label>Occupation:<span class="text-red-500">*</span></label>
                        <input type="text"
                            class="border rounded-md p-2 bg-[#F5F5F5]"
                            data-name="occupation"
                            required>
                    </div>

                    <!-- CIVIL STATUS -->
                    <div class="flex flex-col gap-y-1">
                        <label>Civil Status:<span class="text-red-500">*</span></label>
            
                        <select class="border rounded-md py-2 px-6 bg-[#F5F5F5]"
                            data-name="civil_status"
                        >
                            <option value="" disabled selected hidden>Select</option>
                            <option 
                                value="Single" 
                                {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Single' ? 'selected' : '' }}
                            >
                            Single
                            </option>
                            <option 
                                value="Married" 
                                {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Married' ? 'selected' : '' }}
                            >
                            Married
                            </option>
                            <option 
                                value="Widow/er" 
                                {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Widow/er' ? 'selected' : '' }}
                            >
                            Widow/er
                            </option>
                            <option 
                                value="Separated" 
                                {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Separated' ? 'selected' : '' }}
                            >
                            Separated
                            </option>
                            <option 
                                value="Cohabitation (live-in)" 
                                {{ old('civil_status', $senior->beneficiary->civil_status ?? '') == 'Cohabitation (live-in)' ? 'selected' : '' }}
                            >
                            Cohabitation (live-in)
                            </option>
                        </select>
                    </div>

                    <!-- INCOME -->
                    <div class="flex flex-col gap-y-1">
                        <label>Income:</label>
                        <input type="number"
                            class="border rounded-md p-2 bg-[#F5F5F5] w-full"
                            data-name="income"
                        >
                    </div>

                </div>
            </template>

            <!-- ADD BUTTON -->
            <div id="add-family"
                class="w-[97%] border-2 border-dashed border-gray-400 rounded-lg h-12 hover:bg-gray-100 cursor-pointer transition">
                <span class="w-full flex justify-center items-center h-full text-gray-600">
                    + Add
                </span>
            </div>

        </div>
    </div>
    

    

    

</div>

<script>
    window.oldFamily = @json(old('family', $family_members ?? []));
</script>

