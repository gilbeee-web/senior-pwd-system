@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')


    <div class="flex justify-between items-center">

        <div class="flex gap-x-10">
            <button class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer">
                PWD
            </button>

            <button class="text-2xl font-bold text-gray-400 cursor-pointer">
                Senior Citizen
            </button>
        </div>

        <div class="flex gap-x-5">
            <div class="relative inline-block">
            
                <button
                    class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer"
                    id="addBeneficiary-btn"
                >
                    Add Beneficiary
                </button>

                <!-- Dropdown -->
                <div id="beneficiaryDropdown"
                    class="hidden absolute w-35 bg-white border rounded-lg shadow-lg z-50">

                    <a 
                        href="{{route('senior.create')}}"
                        class="block px-4 py-2 hover:bg-gray-100"
                    >
                        Senior Citizen
                    </a>

                    <a 
                        href="{{route('pwd.create')}}"
                        class="block px-4 py-2 hover:bg-gray-100"
                    >
                        PWD
                    </a>
                </div>

            </div>

            <form id="importPwdForm" action="{{ route('pwd.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="pwdFileInput" accept=".xlsx,.xls,.csv" hidden>
                <button type="button" id="importPwdBtn" class="bg-green-500 text-white px-4 py-2 rounded cursor-pointer">
                    Import PWD
                </button>
            </form>

            <form id="importSeniorForm" action="{{ route('pwd.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" id="seniorFileInput" accept=".xlsx,.xls,.csv" hidden>
                <button type="button" id="importSeniorBtn" class="bg-yellow-500 text-white px-4 py-2 rounded cursor-pointer">
                    Import Senior
                </button>
            </form>
        </div>
        
    </div>

    <div class="mt-5 px-5 py-3 bg-white shadow-md rounded flex justify-between">

        <div class="">
            <label for="" class="font-bold text-sm ml-2">Search:</label>

            <div class="flex gap-x-5">
                <input type="text" class="w-80 rounded-full p-2 border">
                <button class="px-3 py-2 border bg-[#FF9793] font-bold text-md rounded-xl cursor-pointer">Search</button>
            </div>
        </div>

        

        <div class="flex gap-x-5 items-end">

            <!-- Disability Type -->
            <div class="flex flex-col">
                <label for="disability_type" class="font-bold text-sm mb-1">
                    Disability Type
                </label>

                <select name="disability_type" id="disability_type"
                    class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                >
                    
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


            <!-- Barangay -->
            <div class="flex flex-col">
                <label for="barangay" class="font-bold text-sm mb-1">
                    Barangay
                </label>

                <select name="barangay" id="barangay"
                    class="border rounded-md py-2 px-3 bg-[#F5F5F5]">

                    <option value="">All</option>

                    @foreach($barangays as $barangay)

                        <option value="{{ $barangay->id }}">
                            {{ $barangay->name }}
                        </option>

                    @endforeach

                </select>
            </div>


            <!-- Filter Button -->
            <div>
                <button
                    class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md">
                    Apply Filter
                </button>
            </div>

        </div>

       


    </div>


    

    <div class="mt-5 overflow-x-auto" id="pwd-wrapper">
        <table class="w-full text-sm text-center border boder-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID number</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Birthdate</th>
                    <th class="px-4 py-2 border">Gender</th>
                    <th class="px-4 py-2 border">Contact</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @include('beneficiaries.pwd.partials.pwd_rows')
            </tbody>
        </table>
    </div>

    <div class="overflow-x-auto hidden" id="senior-wrapper">
        <table class="w-full text-sm text-center border boder-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID number</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Birthdate</th>
                    <th class="px-4 py-2 border">Gender</th>
                    <th class="px-4 py-2 border">Contact</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @include('beneficiaries.senior.partials.senior_rows')
            </tbody>
        </table>
    </div>

@endsection