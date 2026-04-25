@extends('layouts.app')

@section('title', 'Requests')

@section('content')
    
    <div class="flex gap-x-10">
        <a
            href="{{route('request.index', ['status' => 'pending'])}}"
            class="text-2xl font-bold cursor-pointer
            {{ $tab_status === 'pending' ? 'border-b-[3px] border-red-500' : 'text-gray-400' }}"
        >
            Pending
        </a>

        <a 
            href="{{route('request.index', ['status' => 'approved'])}}"
            id="senior-content-btn"
            class="text-2xl font-bold cursor-pointer
            {{ $tab_status === 'approved' ? 'border-b-[3px] border-red-500' : 'text-gray-400' }}"
        >
            Approved
        </a>

        <a 
            href="{{route('request.index', ['status' => 'rejected'])}}"
            id="senior-content-btn"
            class="text-2xl font-bold cursor-pointer
            {{ $tab_status === 'rejected' ? 'border-b-[3px] border-red-500' : 'text-gray-400' }}"
        >
            Rejected
        </a>

    </div>


    
        
    <div class="mt-10">

        <form action="{{route('request.index')}}" class="flex gap-x-5 items-center">

            <div>
                <select 
                    name="type" 
                    class="border rounded-md py-2 px-8 bg-[#F5F5F5]"
                >
                    <option value="" disabled selected hidden>Select Type</option>
                    <option value="">All</option>
                    <option value="update">Update</option>
                    <option value="archive">Archive</option>
                </select>
            </div>

            <div>
                <select 
                    name="model_type" 
                    class="border rounded-md py-2 px-8 bg-[#F5F5F5]"
                >
                    <option value="" disabled selected hidden>Select Model</option>
                    <option value="">All</option>
                    <option value="senior">Senior</option>
                    <option value="pwd">PWD</option>
                </select>
            </div>

            <div class="flex gap-x-3 items-center">
                <label class="font-semibold">Date Range:</label>
                <input type="date" name="start_date" class="border rounded px-3 py-2 bg-white">
                <span>to</span>
                <input type="date" name="end_date" class="border rounded px-3 py-2 bg-white">
            </div>

            <div>
                <button class="px-5 py-2 bg-blue-500 rounded-lg text-white cursor-pointer flex gap-x-2 items-center">
                    <span>
                        <img src="{{asset('/images/icons/filter.svg')}}" alt="Filter" class="w-6 h-6 object-contain">
                    </span>
                    Apply Filter
                </button>
            </div>

        </form>
        

    </div>

    <div class="mt-5">

        <table class="w-full text-sm text-left border-collapse bg-[#F0F0F0] shadow-md">
            <thead class="text-gray-600 uppercase text-xs border-b">
                <tr class="bg-gray-50">
                    <th class="p-3">FULL NAME</th>
                    <th class="p-3">REQUEST TYPE</th>
                    <th class="p-3">REQUESTED BY</th>
                    <th class="p-3">STATUS</th>
                    <th class="p-3">DATE</th>
                    <th class="p-3">ACTION</th>
                </tr>
            </thead>
            <tbody>
                @include('requests.partials.request_rows')
            </tbody>
        </table>
    </div>

    <div class="hidden" id="review-changes-wrapper">
        @include('requests.partials.show_changes')
    </div>
    



    

@endsection