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
                </div>
                
                <div class="flex justify-between items-center mr-5">

                    @if($current_user->role === 'super_admin' || $current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin')

                        <div class="{{$tab === 'senior' ? '' : 'hidden' }} flex gap-x-5 items-center">

                            <div>
                                <select 
                                    name="status" 
                                    id="status"
                                    class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                                >
                                    <option value="" disabled selected hidden>Select Status</option>
                                    <option value="">All</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="deceased" {{ request('status') == 'deceased' ? 'selected' : '' }}>Deceased</option>
                                    <option value="transferred" {{ request('status') == 'transferred' ? 'selected' : '' }}>Transferred</option>

                                </select>
                            </div>

                            <div class="senior_filter flex gap-x-3 items-center mr-5 {{$tab === 'senior' ? '' : 'hidden' }}">
                                <input type="checkbox" class="h-7 w-7" name="isBday" value="1" {{ request('isBday') == 1 ? 'checked' : '' }}>
                                <label>Birthday Today</label>
                            </div>
                        </div>
                        
                        
                        
                    @endif
                    {{-- <span class="{{$tab === 'senior' ? '' : 'hidden' }}"></span> --}}
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
                            
                            <div>
                                <select 
                                    name="eligibility_status" 
                                    id="eligibility_status"
                                    class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                                >
                                    <option value="" disabled selected hidden>Select Status</option>
                                    <option value="">All</option>
                                    <option value="eligible" {{ request('eligibility_status') == 'eligible' ? 'selected' : '' }}>Eligible</option>
                                    <option value="not_eligible" {{ request('eligibility_status') == 'not_eligible' ? 'selected' : '' }}>Not Eligible</option>

                                </select>
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
                <button 
                    class="open-export-modal p-2 cursor-pointer bg-green-500 hover:bg-green-300 text-white rounded-md flex gap-x-2 items-center" 
                    data-target="pwdModal"
                >
                    <span>
                        <img src="{{asset('/images/icons/export.svg')}}" alt="Export" class="object-contain w-4 h-4">
                    </span>
                    Export Excel
                </button>
            </div>

            <div id="pwdModal" class="modal hidden">
                @include('reports.partials.pwd_export_modal')
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
                            <th class="p-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('reports.partials.pwd_rows_report')
                    </tbody>
                </table>

                <div class="mt-1">
                    @if($pwd_beneficiaries)
                        @include('pagination.pwd_pagination')
                    @endif
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
                <button 
                    class="open-export-modal p-2 cursor-pointer bg-green-500 hover:bg-green-300 text-white rounded-md flex gap-x-2 items-center" 
                    data-target="seniorModal"
                >
                    <span>
                        <img src="{{asset('/images/icons/export.svg')}}" alt="Export" class="object-contain w-4 h-4">
                    </span>
                    Export Excel
                </button>
            </div>

            <div id="seniorModal" class="modal hidden">
                @include('reports.partials.senior_export_modal')
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
                            <th class="p-3">STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('reports.partials.senior_rows_report')
                    </tbody>
                </table>

                <div class="mt-1">
                    @if($senior_beneficiaries)
                        @include('pagination.senior_pagination')
                    @endif
                </div>
                
                
            </div>
        </div>
        
        

        
    @endif


    

@endsection