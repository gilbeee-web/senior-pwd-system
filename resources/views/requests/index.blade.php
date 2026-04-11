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

        <form action="" class="flex gap-x-5 items-center">

            <div>
                <select 
                    name="request_type" 
                    class="border rounded-md py-2 px-8 bg-[#F5F5F5]"
                >
                    <option value="" disabled selected hidden>Select</option>
                    <option value="">All</option>
                    <option value="update">Update</option>
                    <option value="archive">Archive</option>
                </select>
            </div>

            <div>
                <select 
                    name="model" 
                    class="border rounded-md py-2 px-8 bg-[#F5F5F5]"
                >
                    <option value="" disabled selected hidden>Select</option>
                    <option value="">All</option>
                    <option value="senior">Senior</option>
                    <option value="pwd">PWD</option>
                </select>
            </div>

            <div class="flex gap-x-3 items-center">
                <label class="font-semibold">Date Range:</label>
                <input type="date" name="from" class="border rounded px-3 py-2">
                <span>to</span>
                <input type="date" name="to" class="border rounded px-3 py-2">
            </div>

            <div>
                <button class="px-5 py-2 bg-green-500 rounded-lg text-white cursor-pointer">Apply Filter</button>
            </div>

        </form>
        

    </div>

    <div class="mt-5">
        <table class="w-full text-sm text-center border">
            <thead class="bg-[#98D172]">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Type</th>
                    <th class="px-4 py-2 border">Model</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Requested By</th>
                    <th class="px-4 py-2 border">Date</th>
                    <th class="px-4 py-2 border">Status</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody class="bg-[#F0F0F0]">
                @include('requests.partials.request_rows')
            </tbody>
        </table>
    </div>

    <div class="hidden" id="review-changes-wrapper">
        @include('requests.partials.show_changes')
    </div>
    



    

@endsection