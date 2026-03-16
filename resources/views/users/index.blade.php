@extends('layouts.app')

@section('title', 'User Management')

@section('content')

    <div class="flex justify-between items-center">

        <h1 class="font-bold text-3xl">List of Users</h1>

        <button 
            class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer"
            id="addUser-btn"
        >
            Add User
        </button>

    </div>
    

    @include('users.create_user')


    <div class="overflow-y-auto mt-5">
        <table class="w-full text-sm border text-center boder-gray-300">
            <thead class="bg-[#98D172]">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Username</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-[#F0F0F0]">
                @include('users.partials.user-rows')
            </tbody>
        </table>
    </div>

@endsection