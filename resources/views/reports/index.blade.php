@extends('layouts.app')

@section('title', 'Reports')

@section('content')

    <div class="flex gap-x-10">
        <button 
            class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer"
            id="pwd-content-btn"
        >
            PWD
        </button>

        <button 
            class="text-2xl font-bold text-gray-400 cursor-pointer"
            id="senior-content-btn"
        >
            Senior Citizen
        </button>
    </div>

    <div class="mt-5 flex flex-col">
        
        <h1 class="text-lg font-bold">Filter by:</h1>

        <form action="{{route('report.index')}}" method="GET">
            <div class="p-5 bg-white shadow-md rounded flex flex-col gap-y-7">
                <div class="flex gap-x-10 items-center">

                    <div>
                        <select 
                            name="barangay" 
                            id="barangay"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select Barangay</option>
                            <option value="">All</option>

                            @foreach($barangays as $barangay)

                                <option value="{{ $barangay->id }}">
                                    {{ $barangay->name }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                    

                    <div>
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

                                <option value="{{ $disability }}">
                                    {{ $disability }}
                                </option>

                            @endforeach
                        </select>
                    </div>

                    <div>
                        <select 
                            name="gender" 
                            id="gender"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select Gender</option>
                            <option value="">All</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
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
                            ] as $disability)
                                <option value="{{ $disability }}">
                                    {{ $disability }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
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
                                <option value="{{ $educational_attainment }}">
                                    {{ $educational_attainment }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mr-5">

                    <div class="flex gap-x-10 items-center">

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
                                    <option value="{{ $employment_status }}">
                                        {{ $employment_status }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex gap-x-3 items-center">
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

                    <div>
                        <button class="px-5 py-2 bg-green-500 rounded-lg text-white cursor-pointer">Apply Filter</button>
                    </div>

                </div>
                
            </div>
        </form>
        
    </div>

    @if($current_user->role === 'super_admin' || $current_user->role === 'barangay_pwd_admin')

        <div class="w-full flex justify-end mt-5">
            
            <form action="{{ route('report.pwd.export') }}" method="GET">
                <input type="hidden" name="barangay" value="{{ request('barangay') }}">
                <input type="hidden" name="disability_type" value="{{ request('disability_type') }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <input type="hidden" name="civil_status" value="{{ request('civil_status') }}">
                <input type="hidden" name="educational_attainment" value="{{ request('educational_attainment') }}">
                <input type="hidden" name="employment_status" value="{{ request('employment_status') }}">
                <input type="hidden" name="min_age" value="{{ request('min_age') }}">
                <input type="hidden" name="max_age" value="{{ request('max_age') }}">

                <button type="submit" class="hover:underline hover:text-green-500 cursor-pointer">Export Excel</button>
            </form>
        </div>

        <div class="mt-2" id="pwd-table-wrapper">
            <table class="w-full text-sm text-center border">
                <thead class="bg-[#98D172]">
                    <tr>
                        <th class="px-4 py-2 border">ID number</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Birthdate</th>
                        <th class="px-4 py-2 border">Gender</th>
                        <th class="px-4 py-2 border">Disability Type</th>
                        <th class="px-4 py-2 border">Address</th>
                    </tr>
                </thead>
                <tbody>
                    @include('reports.partials.pwd_rows_report')
                </tbody>
            </table>
        </div>
    @endif


    

@endsection