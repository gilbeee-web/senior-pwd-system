@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')

    <a href="{{route('beneficiary.index')}}" class="border p-3 bg-blue-500">
        Back
    </a>

    <div class="mt-5">Update PWD</div>    
    
    <div class="mt-5 w-[30%]">

        @if ($errors->any())
            <div class="bg-red-200 p-3 mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form action="{{route('pwd.update', $pwd->id)}}" method="POST" class="flex flex-col gap-y-5">
            
            @csrf
            @method('put')

            @include('beneficiaries.pwd.partials.pwd_form_fields')

            <div class="">
                <button class="border p-3 bg-blue-500 text-white" type="submit">Update</button>
            </div>

        </form>

    </div>




@endsection