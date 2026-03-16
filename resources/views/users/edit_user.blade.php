@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    {{-- <div class="flex justify-center items-center p-5 border">
        <h1>Account Settings</h1>

        <hr>
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            @method('put')

            @include('users.partials.user_form_fields')

            <div class="flex justify-end mt-4">
                <button type="submit" class="p-4 bg-blue-500 rounded-lg cursor-pointer text-white">Update</button>
            </div>
        </form>

    </div> --}}

    

    <div class="w-full flex justify-center">
        <div class="w-full flex flex-col shadow-lg rounded-lg bg-white p-5">

            {{-- @if ($errors->any())
                <div class="bg-red-200 p-3 mb-4">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif --}}

            <div class="w-full flex justify-between items-center px-5">
                <span class="font-bold text-2xl text-[#172373]"><u>Account Settings</u></span>

                <span class="text-[40px]">
                    <a href="">
                        &times;
                    </a>
                </span>
            </div>

            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
                @csrf
                @method('put')

                @include('users.partials.user_form_fields')

                <div class="flex justify-end mt-4">
                    <button type="submit" class="p-4 bg-blue-500 rounded-lg cursor-pointer text-white">Update</button>
                </div>
            </form>
            
        </div>
    </div>

    
    

@endsection



