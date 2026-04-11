@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')


    <div class="flex justify-between items-center">

        @if($current_user->role === 'super_admin')
            <div class="flex gap-x-10">
                <button 
                    id="pwd-content-btn"
                    class="text-2xl font-bold cursor-pointer 
                    {{ $tab === 'pwd' ? 'border-b-[3px] border-red-500' : 'text-gray-400' }}"
                >
                    PWDs
                </button>

                <button 
                    id="senior-content-btn"
                    class="text-2xl font-bold cursor-pointer 
                    {{ $tab === 'senior' ? 'border-b-[3px] border-red-500' : 'text-gray-400' }}"
                >
                    Senior Citizen
                </button>
            </div>
        @elseif($current_user->role === 'barangay_pwd_admin')
            <div>
                <h1 class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer">Person With Disabilities</h1>
            </div>
        @elseif($current_user->role === 'barangay_senior_admin')
            <div>
                <h1 class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer">Senior Citizens</h1>
            </div>
        @endif

        <div class="flex gap-x-5 mr-5 items-center">

            @if($current_user->role === 'barangay_pwd_admin' || $current_user->role === 'super_admin')

                <div class="pwd-action-btn">
                    <a
                        href="{{route('pwd.create')}}"
                        class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer
                        "
                    >
                        New PWD
                    </a>
                </div>
                
                <div class="pwd-action-btn">
                    <form action="{{ route('pwd.import') }}" method="POST" enctype="multipart/form-data" class="import-form">
                        @csrf
                        <input type="file" name="pwd_file" class="file-input hidden" accept=".xlsx,.xls,.csv">
                        <button
                            type="button"
                            class="import-btn p-2 bg-green-500 text-white rounded-lg cursor-pointer
                            "
                        >
                            Import PWD
                        </button>
                    </form>
                </div>
                
                <div class="pwd-action-btn">
                    <a
                        href="{{route('beneficiary.getArchive', "pwd")}}"
                        class="p-2 bg-green-500 text-white rounded-lg cursor-pointer"
                    >
                        Archived
                    </a>
                </div>
                
            @endif

            @if($current_user->role === 'barangay_senior_admin' || $current_user->role === 'super_admin')

                <div class="senior-action-btn hidden">
                    <a
                        href="{{route('senior.create')}}"
                        class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer"
                    >
                        New Senior Citizen
                    </a>
                </div>
                
                <div class="senior-action-btn hidden">
                    <form action="{{ route('senior.import') }}" method="POST" enctype="multipart/form-data" class="import-form">
                        @csrf
                        <input type="file" name="senior_file" class="file-input hidden" accept=".xlsx,.xls,.csv">
                        <button
                            class="import-btn p-2 bg-green-500 text-white rounded-lg cursor-pointer"
                        >
                            Import Senior Citizen
                        </button>
                    </form>
                </div>
                
                <div class="senior-action-btn hidden">
                    <a
                        href="{{route('beneficiary.getArchive', "senior")}}"
                        class="archive-btn p-2 bg-green-500 text-white rounded-lg cursor-pointer"
                    >
                        Archived
                    </a>
                </div>
                
            @endif

           
        </div>

        
    </div>

    <form method="GET" action="{{ route('beneficiary.index') }}">
        <div class="mt-5 px-5 py-3 bg-white shadow-md rounded flex justify-between">

            <div class="">
                <label for="" class="font-bold text-sm ml-2">Search:</label>

                <input type="hidden" name="tab" id="activeReport-tab" value="{{ request('tab', 'pwd') }}">

                <div class="flex gap-x-5">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search name or ID..." 
                        class="w-80 rounded-full p-2 border"
                    >
                    <button 
                        type="submit" 
                        class="px-3 py-2 border bg-[#FF9793] font-bold text-md rounded-xl cursor-pointer"
                    >
                        Search
                    </button>
                </div>
            </div>
            
            

            

            <div class="flex gap-x-5 items-end">

                @if($current_user->role === 'barangay_pwd_admin')
                    <!-- Disability Type -->
                    <div class="flex flex-col" id="disabilityType-filter">
                        <label for="disability_type" class="font-bold text-sm mb-1">
                            Disability Type
                        </label>

                        <select name="disability_type" id="disability_type"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select</option> 
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
                @elseif($current_user->role === 'barangay_senior_admin')
                    <div class="flex flex-col " id="seniorType-filter">
                        <label for="senior_type" class="font-bold text-sm mb-1">
                            Senior Type
                        </label>

                        <select name="senior_type" id="senior_type"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select</option>
                            <option value="">All</option>

                            @foreach([
                                'Senior',
                                'Octogenarian',
                                'Nonagenarian',
                                'Centenarian'
                            ] as $senior)

                                <option value="{{ $senior }}">
                                    {{ $senior }}
                                </option>

                            @endforeach
                        </select>
                    </div>
                @elseif($current_user->role === 'super_admin')

                    <div class="flex flex-col" id="disabilityType-filter">
                        <label for="disability_type" class="font-bold text-sm mb-1">
                            Disability Type
                        </label>

                        <select name="disability_type" id="disability_type"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select</option>
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

                    <div class="flex flex-col hidden" id="seniorType-filter">
                        <label for="senior_type" class="font-bold text-sm mb-1">
                            Senior Type
                        </label>

                        <select name="senior_type" id="senior_type"
                            class="border rounded-md py-2 px-1 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select</option>
                            <option value="">All</option>

                            @foreach([
                                'Senior',
                                'Octogenarian',
                                'Nonagenarian',
                                'Centenarian'
                            ] as $senior)

                                <option value="{{ $senior }}">
                                    {{ $senior }}
                                </option>

                            @endforeach
                        </select>
                    </div>


                    
                @endif


                <!-- Barangay -->
                <div class="flex flex-col">
                    <label for="barangay" class="font-bold text-sm mb-1">
                        Barangay
                    </label>

                    <select name="barangay" id="barangay"
                        class="border rounded-md py-2 px-3 bg-[#F5F5F5]">
                        <option value="" disabled selected hidden>Select</option>
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
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md"
                        type="submit"
                    >
                        Apply Filter
                    </button>
                </div>

            </div>
        </div>
    </form>


    
    @if($current_user->role === 'super_admin' || $current_user->role === 'barangay_pwd_admin')

        <div class="mt-5 " id="pwd-table-wrapper">
            <table class="w-full text-sm text-center border">
                <thead class="bg-[#98D172]">
                    <tr>
                        <th class="px-4 py-2 border text-center">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th class="px-4 py-2 border">ID number</th>
                        <th class="px-4 py-2 border">Name</th>
                        {{-- <th class="px-4 py-2 border">Birthdate</th> --}}
                        <th class="px-4 py-2 border">Disability Type</th>
                        <th class="px-4 py-2 border">Street</th>
                        <th class="px-4 py-2 border">Barangay</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @include('beneficiaries.pwd.partials.pwd_rows')
                </tbody>
            </table>
        </div>

        @if($current_user->role === 'super_admin' || $current_user->role === 'barangay_pwd_admin')

            <div class="mt-3 flex gap-x-3 items-center "" id="validate-field">
                <button 
                    type="button" 
                    id="bulk-update-btn"
                    class="bg-gray-400 text-white px-4 py-2 rounded cursor-not-allowed"
                    disabled
                >
                    Validate
                </button>

                <span id="selected-count" class="ml-2 text-sm text-gray-600"></span>
            </div>

            <div id="bulkUpdate-modal" class="hidden">
                @include('beneficiaries.pwd.partials.bulkUpdate_modal')
            </div>
        @endif


        {{-- show pwd --}}
        <div id="show-pwd-wrapper" class="hidden">
            @include('beneficiaries.pwd.partials.show_pwd')
        </div>

    @endif
    
    @if($current_user->role === 'super_admin' || $current_user->role === 'barangay_senior_admin')
        <div class="mt-5 overflow-x-auto hidden" id="senior-table-wrapper">
            <table class="w-full text-sm text-center border boder-gray-300">
                <thead class="bg-[#98D172]">
                    <tr>
                        <th class="px-4 py-2 border">ID number</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Birthdate</th>
                        <th class="px-4 py-2 border">Street</th>
                        <th class="px-4 py-2 border">Barangay</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @include('beneficiaries.senior.partials.senior_rows')
                </tbody>
            </table>
        </div>

        {{-- show senior citizen --}}
        <div id="show-senior-wrapper" class="hidden">
            @include('beneficiaries.senior.partials.show_senior')
        </div>
    @endif
    

    
        

@endsection