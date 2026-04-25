@extends('layouts.app')

@section('title', 'User Management')

@section('content')

    <div class="flex justify-between items-center">

       
        <h1 class="font-bold text-3xl border-b-[3px] border-red-500">List of Users</h1>

        <button 
            class="p-2 bg-blue-500 text-white rounded-lg flex gap-x-3 items-center cursor-pointer"
            id="addUser-btn"
        >
            <span class="object-contain w-6 h-6"><img src="{{asset('/images/icons/add-user.svg')}}" alt=""></span>Add User
        </button>

    </div>
    

    @include('users.create_user')


    <div class="mt-5">
        <table class="w-full text-sm text-left border-collapse bg-[#F0F0F0] shadow-md">
            <thead class="text-gray-600 uppercase text-xs border-b">
                <tr class="bg-gray-50">
                    <th class="p-3">FULL NAME</th>
                    <th class="p-3">USERNAME</th>
                    <th class="p-3">ROLE</th>
                    <th class="p-3">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="bg-[#F0F0F0]">
                @include('users.partials.user-rows')
            </tbody>
        </table>
    </div>

@endsection