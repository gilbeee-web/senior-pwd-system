@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')

    <div class="w-full flex flex-col justify-center shadow-lg rounded-lg bg-white">

        @if ($errors->any())
            <div class="bg-red-200 p-3 mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="w-full flex justify-between items-center px-5">
            <span class="font-bold text-2xl text-[#172373]"><u>Update Senior Citizen</u></span>

            <span class="text-[40px]">
                <a href="{{route('beneficiary.index')}}">
                    &times;
                </a>
            </span>
        </div>

        <form id="senior_form" data-form-type="update" action="{{route('senior.update', $senior->id)}}" method="POST" class="flex flex-col gap-y-5 mb-5">
            
            @csrf
            @method('put')

            @include('beneficiaries.senior.partials.senior_form_fields')

            <hr class="text-[#172373]">

            <div class="w-full flex justify-end px-5 gap-x-5">

                <a
                    href="{{route('beneficiary.index')}}""
                    class="p-3 bg-[#DFDFDF] text-[#787878] rounded-md cursor-pointer shadow-lg" 
                >
                    Cancel
                </a>

                <button 
                    class="p-3 bg-green-500 text-white rounded-md cursor-pointer shadow-lg" 
                    type="submit"
                    id="submitBtn"
                >
                    Update
                </button>

            </div>

        </form>

    </div>

@endsection