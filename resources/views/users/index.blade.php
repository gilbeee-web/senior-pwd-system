@extends('layouts.app')

@section('title', 'User Management')

@section('content')

    <h1>User Management Page</h1>

    <button 
        class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer"
        id="addUser-btn"
    >
        Add User
    </button>

    @include('users.create_user')


    <div class="overflow-x-auto">
        <table class="w-full text-sm text-center border boder-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Username</th>
                    <th class="px-4 py-2 border">Role</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @include('users.partials.user-rows')
            </tbody>
        </table>
    </div>

@endsection