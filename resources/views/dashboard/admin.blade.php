@extends('layouts.app')


@section('title', 'Barangay Admin Dashboard')
@section('content')
    <form action="{{route('user.logout')}}" method="POST" class="flex items-center gap-3 hover:text-red-400 transition hover-logout">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <h1>WELCOME BARANGAY Admin</h1>
@endsection