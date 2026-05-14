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
        @elseif($current_user->role === 'barangay_pwd_admin' || $current_user->role === 'pwd_admin')
            <div>
                <h1 class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer">Person With Disabilities</h1>
            </div>
        @elseif($current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin')
            <div>
                <h1 class="text-2xl font-bold border-b-[3px] border-red-500 cursor-pointer">Senior Citizens</h1>
            </div>
        @endif

        

        @if($current_user->role === 'barangay_pwd_admin' || $current_user->role === 'super_admin' || $current_user->role === 'pwd_admin')

            <div class="flex gap-x-5 items-center {{ $tab === 'pwd' ? '' : 'hidden' }}">
                <div class="pwd-action-btn">
                    <a
                        href="{{route('pwd.create')}}"
                        class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer flex gap-x-3 items-center
                        "
                    >
                        <span class="">
                            <img src="{{asset('/images/icons/add-user.svg')}}" alt="" class="h-5 w-5 object-contain">
                        </span>
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
                            flex gap-x-3 items-center
                            "
                        >
                            <span class="">
                                <img src="{{asset('/images/icons/import.svg')}}" alt="" class="h-5 w-5 object-contain">
                            </span>
                            Import PWD
                        </button>
                    </form>
                </div>
                
                @if($current_user->role !== 'barangay_pwd_admin')
                    <div class="pwd-action-btn">
                        <a
                            href="{{route('beneficiary.getArchive', "pwd")}}"
                            class="p-2 bg-gray-400 text-white rounded-lg cursor-pointer flex gap-x-3 items-center"
                        >
                            <span class="">
                                <img src="{{asset('/images/icons/archive-alt.svg')}}" alt="" class="h-5 w-5 object-contain">
                            </span>
                            Archived
                        </a>
                    </div>
                @endif
            </div>
        @endif

        @if($current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin' || $current_user->role === 'super_admin')
            <div class="flex gap-x-5 items-center {{ $tab === 'senior' ? '' : 'hidden' }}">
                <div class="senior-action-btn">
                    <a
                        href="{{route('senior.create')}}"
                        class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer flex gap-x-3 items-center"
                    >
                        <span class="">
                            <img src="{{asset('/images/icons/add-user.svg')}}" alt="" class="h-5 w-5 object-contain">
                        </span>
                        New Senior Citizen
                    </a>
                </div>
                
                <div class="senior-action-btn">
                    <form action="{{ route('senior.import') }}" method="POST" enctype="multipart/form-data" class="import-form">
                        @csrf
                        <input type="file" name="senior_file" class="file-input hidden" accept=".xlsx,.xls,.csv">
                        <button
                            class="import-btn p-2 bg-green-500 text-white rounded-lg cursor-pointer flex gap-x-3 items-center"
                        >
                            <span class="">
                                <img src="{{asset('/images/icons/import.svg')}}" alt="" class="h-5 w-5 object-contain">
                            </span>
                            Import Senior Citizen
                        </button>
                    </form>
                </div>
                
                @if($current_user->role !== 'barangay_senior_admin')
                    <div class="senior-action-btn">
                        <a
                            href="{{route('beneficiary.getArchive', "senior")}}"
                            class="p-2 bg-gray-400 text-white rounded-lg cursor-pointer flex gap-x-3 items-center"
                        >
                            <span class="">
                                <img src="{{asset('/images/icons/archive-alt.svg')}}" alt="" class="h-5 w-5 object-contain">
                            </span>
                            Archived
                        </a>
                    </div>
                @endif
            </div>
            
        @endif

    

        
    </div>

    <form method="GET" action="{{ route('beneficiary.index') }}" id="filter-form">
        <div class="mt-5 px-5 py-3 bg-white shadow-md rounded flex justify-between">

            <div class="">
                <label for="" class="font-bold text-sm ml-2">Search:</label>

                <input type="hidden" name="tab" id="active-tab" value="{{ request('tab', 'pwd') }}">

                <div class="flex gap-x-5">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search name or ID..." 
                        class="w-80 rounded-full p-2 border"
                    >
                    <button 
                        type="submit" 
                        class="px-3 py-2 bg-green-500 font-bold text-md rounded-xl cursor-pointer flex items-center text-white"
                    >
                        <img src="{{asset('/images/icons/search.svg')}}" alt="Search icon" class="object-contain w-5 h-5">
                        Search
                    </button>
                </div>
            </div>
            
            

            

            <div class="flex gap-x-5 items-end">

                @if($current_user->role === 'barangay_pwd_admin' || $current_user->role === 'pwd_admin' || $current_user->role === 'super_admin')
                    <!-- Disability Type -->
                    <div class="flex flex-col {{ $tab === 'pwd' ? '' : 'hidden' }}" id="disabilityType-filter">
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

                @if($current_user->role === 'barangay_senior_admin' || $current_user->role === 'senior_admin' || $current_user->role === 'super_admin')
                    <div class="flex flex-col {{ $tab === 'senior' ? '' : 'hidden' }}" id="seniorType-filter">
                        <label for="senior_type" class="font-bold text-sm mb-1">
                            Senior Type
                        </label>

                        <select 
                            name="senior_type" id="senior_type"
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
                {{-- @elseif($current_user->role === 'super_admin')

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


                    
                @endif --}}


                <!-- Barangay -->
                @if($current_user->role !== 'barangay_pwd_admin' && $current_user->role !== 'barangay_senior_admin')
                    <div class="flex flex-col">
                        <label for="barangay" class="font-bold text-sm mb-1">
                            Barangay
                        </label>

                        <select 
                            name="barangay" id="barangay"
                            class="border rounded-md py-2 px-3 bg-[#F5F5F5]"
                        >
                            <option value="" disabled selected hidden>Select</option>
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
                @endif
                
                <!-- Filter Button -->
                <div>
                    <button
                        class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-md flex gap-x-2 items-center cursor-pointer"
                        type="submit"
                    >
                        <span class="">
                            <img src="{{asset('/images/icons/filter.svg')}}" alt="" class="h-5 w-5 object-contain">
                        </span>
                        Apply Filter
                    </button>
                </div>

            </div>
        </div>
    </form>


    
    @if(
        $current_user->role === 'super_admin' || 
        $current_user->role === 'barangay_pwd_admin' || 
        $current_user->role === 'pwd_admin'
    )

        <div class="mt-5 w-full {{ $tab === 'pwd' ? '' : 'hidden' }}" id="pwd-table-wrapper">

            <div class="w-full overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                    <thead class="text-gray-600 uppercase text-xs border-b">
                        <tr class="bg-gray-50">
                            <th class="h-10 p-3">
                                <input type="checkbox" class="select-all h-4 w-4" data-type="pwd">
                            </th>
                            <th class="p-3">ID NO.</th>
                            <th class="p-3">FULL NAME</th>
                            <th class="p-3">BIRTHDATE</th>
                            <th class="p-3">ADDRESS</th>
                            <th class="p-3">DISABILITY TYPE</th>
                            <th class="p-3">DATE ID ISSUE</th>
                            <th class="p-3">DATE ID EXPIRATION</th>
                            <th class="p-3">STATUS</th>
                            <th class="p-3">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('beneficiaries.pwd.partials.pwd_rows')
                    </tbody>
                </table>
            </div>
            
            <div class="flex justify-between items-center">
                <div>
                    <span class="selected-count text-gray-600 text-sm font-semibold" data-type="pwd"></span>

                    <div class="selected-pwd-action-field mt-2 flex gap-x-3 items-center hidden">
                        <form action="{{route('pwd.print')}}" class="generate-id-form" data-type="pwd" method="POST">
                            @csrf
                            <button 
                                type="submit" 
                                class="bg-green-500 text-white rounded-lg p-2 cursor-pointer flex gap-x-2 items-center"
                            >
                                <span>
                                    <img src="{{asset('/images/icons/generate-id.svg')}}" alt="generate-id">
                                </span>
                                Generate ID
                            </button>

                        </form>

                        <button 
                            type="button" 
                            data-type="pwd"
                            class="bulk-update-btn bg-blue-500 text-white rounded-lg p-2 cursor-pointer flex gap-x-3 items-center"
                        >
                            <span>
                                <img src="{{asset('/images/icons/validate.svg')}}" alt="validate">
                            </span>
                            Validate
                        </button>
                    </div>

                    <div class="bulkUpdate-modal hidden" data-type="pwd">
                        @include('beneficiaries.pwd.partials.pwd_bulkUpdate_modal')
                    </div>
                   
                </div>

                <div id="pwd-rows-pagination">
                    @if($pwd_beneficiaries)
                        @include('pagination.pwd_pagination')
                    @endif
                </div>
            </div>

            {{-- show pwd --}}
            <div id="show-pwd-wrapper" class="hidden">
                @include('beneficiaries.pwd.partials.show_pwd')
            </div>

        </div>
    @endif
    
    @if(
        $current_user->role === 'super_admin' || 
        $current_user->role === 'barangay_senior_admin' || 
        $current_user->role === 'senior_admin'
    )
        <div class="mt-5 w-full {{ $tab === 'senior' ? '' : 'hidden' }}" id="senior-table-wrapper">
            <div class="w-full overflow-x-auto ">
                <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                    <thead class="text-gray-600 uppercase text-xs border-b">
                        <tr class="bg-gray-50">
                            <th class="h-10 p-3">
                                <input type="checkbox" class="select-all h-4 w-4" data-type="senior">
                            </th>
                            <th class="p-3">ID NO.</th>
                            <th class="p-3">FULL NAME</th>
                            <th class="p-3">BIRTHDATE</th>
                            <th class="p-3">ADDRESS</th>
                            <th class="p-3">DATE ID ISSUE</th>
                            <th class="p-3">STATUS</th>
                            <th class="p-3">ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('beneficiaries.senior.partials.senior_rows')
                    </tbody>
                </table>
            </div>
            

            <div class="w-full flex justify-between items-center">
                
                <div>
                    <span class="selected-count text-gray-600 text-sm font-semibold" data-type="senior"></span>

                    <div class="selected-senior-action-field mt-3 flex gap-x-3 items-center hidden">
                        <form action="{{route('senior.print')}}" class="generate-id-form" data-type="senior" method="POST">
                            @csrf
                            <button 
                                type="submit" 
                                class="bg-green-500 text-white rounded-lg p-2 cursor-pointer flex gap-x-2 items-center"
                            >
                                <span>
                                    <img src="{{asset('/images/icons/generate-id.svg')}}" alt="generate-id">
                                </span>
                                Generate ID
                            </button>
                        </form>

                        <button 
                            type="button" 
                            data-type="senior"
                            class="bulk-update-btn bg-blue-500 text-white rounded-lg p-2 cursor-pointer flex gap-x-3 items-center"
                        >
                            <span>
                                <img src="{{asset('/images/icons/validate.svg')}}" alt="validate">
                            </span>
                            Validate
                        </button>
                    </div>
                </div>

                <div class="bulkUpdate-modal hidden" data-type="senior">
                    @include('beneficiaries.senior.partials.senior_bulkUpdate_modal')
                </div>
                


                <div id="senior-rows-pagination">
                    @if($senior_beneficiaries)
                        @include('pagination.senior_pagination')
                    @endif
                </div>
            </div>

            {{-- show senior citizen --}}
            <div id="show-senior-wrapper" class="hidden">
                @include('beneficiaries.senior.partials.show_senior')
            </div>
        </div>

        
    @endif
    

    
        

@endsection