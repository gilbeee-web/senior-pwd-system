@extends('layouts.app')

@section('title', 'System Settings')

@section('content')

    {{-- <button type="submit" class="p-4 bg-blue-500 rounded-lg cursor-pointer text-white" id="add-employee-btn">
        Add Employee
    </button> --}}

    <div class="flex justify-between items-center">


        <h1 class="font-bold text-3xl border-b-[3px] border-red-500">Authorize Employees</h1>

        <button 
            class="p-2 bg-blue-500 text-white rounded-lg flex gap-x-3 items-center cursor-pointer"
            id="add-employee-btn"
        >
            <span class="object-contain w-6 h-6"><img src="{{asset('/images/icons/add-user.svg')}}" alt=""></span>
            Add Employee
        </button>
    </div>

    

    <div id="authorize-employee-form-wrapper" class="{{ $errors->any() || $employee ? '' : 'hidden' }}">
        @if($employee)
            @include('authorize_employee.edit_authorize_employee')
        @else
            @include('authorize_employee.create_authorize_employee')
        @endif
    </div>  
    

    <div class="mt-5">
        <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                <thead class="text-gray-600 uppercase text-xs border-b">
                    <tr class="bg-gray-50">
                        <th class="p-3">FULL NAME</th>
                        <th class="p-3">POSITION / LABELED AS</th>
                        <th class="p-3">ROLE</th>
                        <th class="p-3">STATUS</th>
                        <th class="p-3">ACTIONS</th>
                    </tr>
                </thead>
            <tbody class="bg-[#F0F0F0]">
                @include('authorize_employee.partials.authorize_employee_rows')
            </tbody>
        </table>
    </div>



@endsection