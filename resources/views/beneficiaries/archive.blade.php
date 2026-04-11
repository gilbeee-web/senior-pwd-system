@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')

    <a href="{{route('beneficiary.index')}}">
        Back
    </a>

    <div class="mt-10 flex justify-between items-center">
        <h1 class="text-2xl font-bold border-b-[3px] border-red-500 inline-block">
            Archived {{ $type === 'pwd' ? 'PWD' : 'Senior Citizen' }}
        </h1>

        @if($type === 'pwd')
            <form action="{{route('pwd.destroyAll')}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete ALL archived PWD members? This action cannot be undone.'">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 bg-red-500 cursor-pointer">
                    Delete All
                </button>
            </form>
        @else
            <form action="{{route('senior.destroyAll')}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete ALL archived Senior Citizen members? This action cannot be undone.'">
                @csrf
                @method('DELETE')
                <button type="submit" class="p-2 bg-red-500 cursor-pointer">
                    Delete All
                </button>
            </form>
        @endif

    </div>

    <div class="mt-5 ">
        @if($type === 'pwd')
            <table class="w-full text-sm text-center border">
                <thead class="bg-[#98D172]">
                    <tr>
                        <th class="px-4 py-2 border">ID number</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Disability Type</th>
                        <th class="px-4 py-2 border">Street</th>
                        <th class="px-4 py-2 border">Barangay</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $pwd)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->pwd_id_number}}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->last_name}} {{$pwd->beneficiary->first_name}} {{$pwd->beneficiary->middle_name}} </td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->disability_type}}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->address->street->name}} St.</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">
                                {{$pwd->beneficiary->address->street->barangay->name}}
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 border flex gap-x-3 justify-center">
                                
                                <form action="{{route('pwd.restore', $pwd->id)}}" method="POST">
                                    @csrf
                                    <button type="submit">
                                        Restore
                                    </button>
                                </form>

                                <form action="{{route('pwd.destroy', $pwd->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to permanently delete this PWD member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
                                No result found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'senior')
            <table class="w-full text-sm text-center border">
                <thead class="bg-[#98D172]">
                    <tr>
                        <th class="px-4 py-2 border text-center">
                            <input type="checkbox" class="select-all">
                        </th>   
                        <th class="px-4 py-2 border">ID number</th>
                        <th class="px-4 py-2 border">Name</th>
                        <th class="px-4 py-2 border">Birthdate</th>
                        <th class="px-4 py-2 border">Street</th>
                        <th class="px-4 py-2 border">Barangay</th>
                        <th class="px-4 py-2 border text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $senior)
                        <tr>
                            <td class="px-4 py-2 text-center border">
                                <input 
                                    type="checkbox" 
                                    class="row-checkbox"
                                    name="selected_seniors[]"
                                    value="{{ $senior->id }}"
                                >
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->osca_id_number}}</td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->beneficiary->last_name}} {{$senior->beneficiary->first_name}} {{$pwd->beneficiary->middle_name}} </td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">{{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->format('F d, Y') }}</td>
                            
                            <td class="px-4 py-2 text-sm text-gray-800 border">
                                {{$senior->beneficiary->address->street->name}} St.
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-800 border">
                                {{$senior->beneficiary->address->street->barangay->name}}
                            </td>

                            <td class="px-4 py-2 text-sm text-gray-800 border">
                                <a href="{{route('senior.restore', $senior->id)}}">
                                    Restore
                                </a>

                                <a href="{{route('senior.destroy', $senior->id)}}">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
                                No result found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
    




@endsection