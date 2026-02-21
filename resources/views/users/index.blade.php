@extends('layouts.app')

@section('title', 'Manage Participants')

@section('content')

    <h1>User Management Page</h1>

    <button 
        class="p-2 bg-blue-500 text-white rounded-lg cursor-pointer"
        id="addUser-btn"
    >
        Add User
    </button>

    @include('users.create_user')

@endsection