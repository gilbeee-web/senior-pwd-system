@extends('layouts.app')

@section('title', 'Reports')

@section('content')

    @if($current_user->role === 'super_admin')
        <div class="flex gap-x-10">
            <button 
                id="pwd-report-content-btn"
                class="text-2xl font-bold cursor-pointer 
                {{ $tab === 'pwd' ? 'border-b-[3px] border-red-500' : 'text-gray-400' }}"
            >
                PWD
            </button>

            <button 
                id="senior-report-content-btn"
                class="text-2xl font-bold cursor-pointer 
                {{ $tab === 'senior' ? 'border-b-[3px] border-red-500' : 'text-gray-400' }}"
            >
                Senior Citizen
            </button>
        </div>
    @elseif($current_user->role === 'barangay_pwd_admin' || $current_user->role === 'pwd_admin')
        <div>
            <button class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer">Person With Disabilities</button>
        </div>
    @elseif($current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin')
        <div>
            <button class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer">Senior Citizen</button>
        </div>
    @endif
    

    <div class="mt-5 flex flex-col">
        
        <h1 class="text-lg font-bold">Filter by:</h1>

        <form action="{{route('report.index')}}" method="GET" id="report-filter-form">
            <div class="p-5 bg-white shadow-md rounded flex flex-col gap-y-7">
                <div class="flex gap-x-7 items-center">

                    <input type="hidden" name="tab" id="activeReport-tab" value="{{ request('tab', 'pwd') }}">

                    <div>
                        <select 
                            name="barangay" 
                            id="barangay"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select Barangay</option>
                            <option value="">All</option>

                            @foreach($barangays as $barangay)

                                <option 
                                    value="{{ $barangay->id }}"
                                    {{ request('barangay') == $barangay->id ? 'selected' : '' }}
                                >
                                    {{ $barangay->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                    
                    @if(
                        $current_user->role === 'super_admin' || 
                        $current_user->role === 'barangay_pwd_admin' || 
                        $current_user->role === 'pwd_admin'
                    )
                        <div class="pwd_filter {{$tab === 'pwd' ? '' : 'hidden' }}">
                            <select 
                                name="disability_type" 
                                id="disability_type"
                                class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                            >
                                <option value="" disabled selected hidden>Select Disability Type</option>
                                <option value="">All</option>

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
                                        {{ request('disability_type') == $disability ? 'selected' : '' }}
                                    >
                                        {{ $disability }}
                                    </option>

                                @endforeach
                            </select>
                        </div>
                    @endif

                    @if(
                        $current_user->role === 'super_admin' || 
                        $current_user->role === 'barangay_senior_admin' || 
                        $current_user->role === 'senior_admin'
                    )
                        <div class="senior_filter {{$tab === 'senior' ? '' : 'hidden' }} flex gap-x-10">
        
                            <select 
                                name="senior_type"
                                class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                            >
                                <option value="" disabled selected hidden>Select Senior Type</option>
                                <option value="">All</option>

                                @foreach([
                                    'Senior',
                                    'Octogenarian',
                                    'Nonagenarian',
                                    'Centenarian'
                                ] as $senior)

                                    <option 
                                        value="{{ $senior }}"
                                        {{ request('senior_type') == $senior ? 'selected' : '' }}
                                    >
                                        {{ $senior }}
                                    </option>

                                @endforeach
                            </select>
                        </div>

                        
                        
                    @endif

                    <div>
                        <select 
                            name="gender" 
                            id="gender"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >   
                            <option value="" disabled selected hidden>Select Gender</option>
                            <option value="">All</option>
                            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <select 
                            name="civil_status" 
                            id="civil_status"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select Civil Status</option>
                            <option value="">All</option>

                            @foreach([
                                'Single',
                                'Married',
                                'Separated',
                                'Widowed',
                                'Cohabitation (Live in)',
                            ] as $civil_status)
                                <option value="{{ $civil_status }}" {{ request('civil_status') == $civil_status ? 'selected' : '' }}>
                                    {{ $civil_status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select 
                            name="employment_status" 
                            id="employment_status"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select Employment Status</option>
                            <option value="">All</option>

                            @foreach([
                                'Employed',
                                'Unemployed',
                                'Self-employed',
                            ] as $employment_status)
                                <option value="{{ $employment_status }}" {{ request('employment_status') == $employment_status ? 'selected' : '' }}>
                                    {{ $employment_status }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($current_user->role === 'super_admin' || $current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin')
                        <div class="senior_filter flex gap-x-3 items-center mr-5 {{$tab === 'senior' ? '' : 'hidden' }}">
                            <input type="checkbox" class="h-7 w-7" name="isBday" value="1" {{ request('isBday') == 1 ? 'checked' : '' }}>
                            <label>Birthday Today</label>
                        </div>
                    @endif
                </div>
                
                <div class="flex justify-between items-center mr-5">
                    <span class="{{$tab === 'senior' ? '' : 'hidden' }}"></span>
                    @if(
                        $current_user->role === 'super_admin' || 
                        $current_user->role === 'barangay_pwd_admin' || 
                        $current_user->role === 'pwd_admin'
                    )  
                        <div class="flex gap-x-10 items-center {{$tab === 'pwd' ? '' : 'hidden' }}">
                            
                                
                            <div class="pwd_filter">
                                <select 
                                    name="educational_attainment" 
                                    id="educational_attainment"
                                    class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                                >
                                    <option value="" disabled selected hidden>Select Educational Attainment</option>
                                    <option value="">All</option>

                                    @foreach([
                                        'None',
                                        'Elementary',
                                        'Junior Highschool',
                                        'Senior Highschool',
                                        'College',
                                        'Vocational',
                                        'Post Graduate'
                                    ] as $educational_attainment)
                                        <option 
                                            value="{{ $educational_attainment }}" 
                                            {{ request('educational_attainment') == $educational_attainment ? 'selected' : '' }}
                                        >
                                            {{ $educational_attainment }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pwd_filter flex gap-x-3 items-center">
                                <label class="font-semibold">Age Range:</label>

                                
                                <input 
                                    type="number"
                                    name="min_age"
                                    value="{{ request('min_age') }}"
                                    class="border p-2 rounded-lg w-[80px]"
                                    placeholder="Min"
                                    min="0"
                                >

                                <span>to</span>

                                <input 
                                    type="number"
                                    name="max_age"
                                    value="{{ request('max_age') }}"
                                    class="border p-2 rounded-lg w-[80px]"
                                    placeholder="Max"
                                    min="0"
                                >
                            </div>                            
                        </div>
                    @endif

                    
                    <div>
                        <button class="px-5 py-2 bg-blue-500 rounded-lg text-white cursor-pointer flex gap-x-2 items-center">
                            <span>
                                <img src="{{asset('/images/icons/filter.svg')}}" alt="" class="w-6 h-6 object-contain">
                            </span>
                            Apply Filter
                        </button>
                    </div>

                </div>
                
            </div>
        </form>
        
    </div>

    @if(
        $current_user->role === 'super_admin' || 
        $current_user->role === 'barangay_pwd_admin' || 
        $current_user->role === 'pwd_admin'
    )
        <div class="w-full mt-5 {{$tab === 'pwd' ? '' : 'hidden' }}">
            <div class="w-full flex justify-end" id="pwd_export_settings">
            
                <form action="{{ route('report.pwd.export') }}" method="GET">
                    <input type="hidden" name="barangay" value="{{ request('barangay') }}">
                    <input type="hidden" name="disability_type" value="{{ request('disability_type') }}">
                    <input type="hidden" name="gender" value="{{ request('gender') }}">
                    <input type="hidden" name="civil_status" value="{{ request('civil_status') }}">
                    <input type="hidden" name="educational_attainment" value="{{ request('educational_attainment') }}">
                    <input type="hidden" name="employment_status" value="{{ request('employment_status') }}">
                    <input type="hidden" name="min_age" value="{{ request('min_age') }}">
                    <input type="hidden" name="max_age" value="{{ request('max_age') }}">

                    <!-- DROPDOWN BUTTON -->
                    <div class="relative inline-block text-left column-wrapper">
                        <button 
                            type="button"
                            class="column-btn px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 flex gap-x-2 items-center"
                        >
                            Select Columns 
                            <span>
                                <img src="{{asset('/images/icons/arrow-down.svg')}}" alt="Arrow down" class="object-contain w-5 h-5">
                            </span>
                        </button>

                        <!-- DROPDOWN CONTENT -->
                        <div
                            class="column-dropdown hidden absolute right-0 mt-2 w-56 bg-white border rounded shadow-lg z-50 p-3 space-y-2"
                        >
                            <!-- SELECT ALL -->
                            <div class="border-b pb-2">
                                <label class="flex items-center gap-2 font-semibold">
                                    <input type="checkbox" class="select-all">
                                    Select All
                                </label>
                            </div>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="pwd_id_number" checked>
                                ID Number
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="name" checked>
                                Name
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="birthdate" checked>
                                Birthdate
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="disability_type" checked>
                                Disability Type
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="gender" checked>
                                Gender
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="street" checked>
                                Street
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="barangay" checked>
                                Barangay
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="civil_status">
                                Civil Status
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="employment_status">
                                Employment Status
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="educational_attainment">
                                Educational Attainment
                            </label>
                        </div>
                    </div>


                    <button type="submit" class="hover:underline hover:text-green-500 cursor-pointer">Export Excel</button>
                </form>
            </div>

            <div class="mt-2" id="pwd-report-table-wrapper">
                <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                    <thead class="text-gray-600 uppercase text-xs border-b">
                        <tr class="bg-gray-50">
                            <th class="p-3">ID NO. / DISABILITY TYPE</th>
                            <th class="p-3">FULL NAME</th>
                            <th class="p-3">BIRTHDATE</th>
                            <th class="p-3">ADDRESS</th>
                            <th class="p-3">CIVIL & EMPLOYMENT STATUS</th>
                            <th class="p-3">EDUCATIONAL ATTAINMENT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('reports.partials.pwd_rows_report')
                    </tbody>
                </table>

                <div class="mt-1">
                    @include('pagination.pwd_pagination')
                </div>
            </div>

        </div>
        
    @endif

    @if(
        $current_user->role === 'super_admin' || 
        $current_user->role === 'barangay_senior_admin' || 
        $current_user->role === 'senior_admin'
    )

        <div class="w-full mt-5 {{$tab === 'senior' ? '' : 'hidden' }}">
            <div class="w-full flex justify-end" id="senior_export_settings">
            
                <form action="{{ route('report.senior.export') }}" method="GET">
                    <input type="hidden" name="barangay" value="{{ request('barangay') }}">
                    <input type="hidden" name="senior_type" value="{{ request('senior_type') }}">
                    <input type="hidden" name="gender" value="{{ request('gender') }}">
                    <input type="hidden" name="civil_status" value="{{ request('civil_status') }}">
                    <input type="hidden" name="employment_status" value="{{ request('employment_status') }}">


                    <!-- DROPDOWN BUTTON -->
                    <div class="relative inline-block text-left column-wrapper">
                        <button 
                            type="button"
                            class="column-btn px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 flex gap-x-2 items-center"
                        >
                            Select Columns 
                            <span>
                                <img src="{{asset('/images/icons/arrow-down.svg')}}" alt="Arrow down" class="object-contain w-5 h-5">
                            </span>
                        </button>

                        <!-- DROPDOWN CONTENT -->
                        <div
                            class="column-dropdown hidden absolute right-0 mt-2 w-56 bg-white border rounded shadow-lg z-50 p-3 space-y-2"
                        >

                            <!-- SELECT ALL -->
                            <div class="border-b pb-2">
                                <label class="flex items-center gap-2 font-semibold">
                                    <input type="checkbox" class="select-all">
                                    Select All
                                </label>
                            </div>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="osca_id_number" checked>
                                ID Number
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="name" checked>
                                Name
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="gender" checked>
                                Gender
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="birthdate" checked>
                                Birthdate
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="age" checked>
                                Age
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="street" checked>
                                Street
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="barangay" checked>
                                Barangay
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="civil_status">
                                Civil Status
                            </label>

                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="columns[]" value="employment_status">
                                Employment Status
                            </label>

                            
                        </div>
                    </div>

                    <button type="submit" class="hover:underline hover:text-green-500 cursor-pointer">
                        Export Excel
                    </button>
                </form>
            </div>

            <div class="mt-2" id="senior-report-table-wrapper">
                <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                    <thead class="text-gray-600 uppercase text-xs border-b">
                        <tr class="bg-gray-50">
                            <th class="p-3">ID NO.</th>
                            <th class="p-3">FULL NAME</th>
                            <th class="p-3">BIRTHDATE</th>
                            <th class="p-3">AGE</th>
                            <th class="p-3">GENDER</th>
                            <th class="p-3">ADDRESS</th>
                            <th class="p-3">CIVIL & EMPLOYMENT STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('reports.partials.senior_rows_report')
                    </tbody>
                </table>

                <div class="mt-1">
                    @include('pagination.senior_pagination')
                </div>
                
                
            </div>
        </div>
        
        

        
    @endif


    

@endsection