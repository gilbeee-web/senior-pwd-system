@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')

    {{-- <a href="{{route('beneficiary.index')}}" class="border p-3 bg-blue-500">
        Back
    </a>

    <div class="mt-5">Register PWD</div>    
    
    <div class="mt-5 w-[30%]">

        @if ($errors->any())
            <div class="bg-red-200 p-3 mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        
        <form action="{{route('pwd.store')}}" method="POST" class="flex flex-col gap-y-5">
            
            @csrf

            @include('beneficiaries.pwd.partials.pwd_form_fields')

            <div class="">
                <button class="border p-3 bg-blue-500 text-white" type="submit">Submit</button>
            </div>

        </form>

    </div> --}}

    <div class="w-full flex flex-col justify-center shadow-lg rounded-lg bg-white">

        @if ($errors->any())
            <div class="bg-red-200 p-3 mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="w-full flex justify-between items-center px-5">
            <span class="font-bold text-2xl text-[#172373]"><u>Register PWD</u></span>

            <span class="text-[40px]">
                <a href="{{route('beneficiary.index')}}">
                    &times;
                </a>
            </span>
        </div>

        <form id="pwd_form" action="{{route('pwd.store')}}" method="POST" class="flex flex-col gap-y-5 mb-5">
            
            @csrf

            @include('beneficiaries.pwd.partials.pwd_form_fields')

            <hr class="text-[#172373]">

            <div class="w-full flex justify-end px-5 gap-x-5">

                <a
                    href="{{route('beneficiary.index')}}""
                    class="p-3 bg-[#DFDFDF] text-[#787878] rounded-md cursor-pointer shadow-lg" 
                >
                    Cancel
                </a>

                <button 
                    class="p-3 bg-[#FF9793] text-white rounded-md cursor-not-allowed shadow-lg" 
                    type="submit"
                    id="submitBtn"
                    disabled
                >
                    Submit
                </button>

            </div>

        </form>

    </div>





@endsection