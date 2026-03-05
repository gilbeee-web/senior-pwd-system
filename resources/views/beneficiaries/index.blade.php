@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')

    <h1>Beneficiary Management Page</h1>

    <div class="relative inline-block">
    
        <button
            class="border p-2 bg-blue-500 text-white rounded-lg cursor-pointer"
            id="addBeneficiary-btn"
        >
            Add New Beneficiary
        </button>

        <!-- Dropdown -->
        <div id="beneficiaryDropdown"
            class="hidden absolute w-48 bg-white border rounded-lg shadow-lg z-50">

            <a href="{{route('senior.create')}}"
            class="block px-4 py-2 hover:bg-gray-100">
                Senior Citizen
            </a>

            <a href="{{route('pwd.create')}}"
            class="block px-4 py-2 hover:bg-gray-100">
                PWD
            </a>

        </div>

    </div>

    <div class="overflow-x-auto" id="pwd-wrapper">
        <table class="w-full text-sm text-center border boder-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID number</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Birthdate</th>
                    <th class="px-4 py-2 border">Gender</th>
                    <th class="px-4 py-2 border">Contact</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @include('beneficiaries.pwd.partials.pwd_rows')
            </tbody>
        </table>
    </div>

    <div class="overflow-x-auto hidden" id="senior-wrapper">
        <table class="w-full text-sm text-center border boder-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID number</th>
                    <th class="px-4 py-2 border">Name</th>
                    <th class="px-4 py-2 border">Birthdate</th>
                    <th class="px-4 py-2 border">Gender</th>
                    <th class="px-4 py-2 border">Contact</th>
                    <th class="px-4 py-2 border">Address</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @include('beneficiaries.senior.partials.senior_rows')
            </tbody>
        </table>
    </div>

@endsection