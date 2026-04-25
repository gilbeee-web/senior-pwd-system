@extends('layouts.app')

@section('title', 'Beneficiaries')

@section('content')

    <div class="w-full flex justify-between items-center">

        <div class="flex gap-x-3 items-center">
            <a href="{{route('beneficiary.index')}}">
                <span>
                    <img src="{{asset('/images/icons/back.svg')}}" alt="">
                </span>
            </a>

            <h1 class="text-2xl font-bold border-b-[3px] border-red-500 inline-block">
                Archived {{ $type === 'pwd' ? 'PWD' : 'Senior Citizen' }}
            </h1>
            
        </div>
        
        <div>
            @if($type === 'pwd')
                <form 
                    action="{{route('pwd.destroyAll')}}" 
                    method="POST" onsubmit="return confirm('Are you sure you want to permanently delete ALL archived PWD members? This action cannot be undone.'"
                >
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 p-2 border border-black cursor-pointer flex gap-x-2 items-center rounded-md hover:bg-gray-300">
                        <span>
                            <img src="{{asset('/images/icons/delete.svg')}}" alt="" class="object-contain w-4 h-4">
                        </span>
                        Delete All
                    </button>
                </form>
            @else
                <form 
                    action="{{route('senior.destroyAll')}}" 
                    method="POST"
                    onsubmit="return confirm('Are you sure you want to permanently delete ALL archived Senior Citizen members? This action cannot be undone.'"
                >
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit" 
                        class="px-3 p-2 border border-black cursor-pointer flex gap-x-2 items-center rounded-md hover:bg-gray-300"
                    >
                        Delete All
                    </button>
                </form>
            @endif
        </div>
    </div>
    
    <div class="mt-5">
        @if($type === 'pwd')
            <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                <thead class="text-gray-600 uppercase text-xs border-b">
                    <tr class="bg-gray-50">
                        <th class="p-3">ID NO.</th>
                        <th class="p-3">FULL NAME</th>
                        <th class="p-3">BIRTHDATE</th>
                        <th class="p-3">ADDRESS</th>
                        <th class="p-3">DISABILITY TYPE</th>
                        <th class="p-3">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $pwd)
                        <tr class="border-b hover:bg-gray-100">

                            <td class="p-3">{{$pwd->pwd_id_number}}</td>

                            <td class="p-3 uppercase">
                               {{$pwd->beneficiary->first_name}} {{$pwd->beneficiary->middle_name ?? " "}} {{$pwd->beneficiary->last_name}} 
                            </td>
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('m-d-Y') }}
                            </td>

                            <td class="p-3">
                                <h1 class="text-md uppercase">{{$pwd->beneficiary->address->street->barangay->name}}</h1>
                                <p class="text-xs">{{$pwd->beneficiary->address->street->name}} St.</p>
                            </td>

                            <td class="p-3 uppercase">{{$pwd->disability_type}}</td>

                            <td class="p-3 text-sm relative">
                                <!-- Button -->
                                <button class="archive-more-action-btn cursor-pointer hover:bg-gray-200 rounded-full p-1">
                                    <img src="{{ asset('/images/icons/more-action.svg') }}" class="w-5 h-5">
                                </button>

                                <!-- Dropdown -->
                                <div class="archive-more-action-wrapper hidden absolute right-5 top-10 w-30 bg-white rounded-lg shadow-lg z-50">
                                    <form action="{{route('pwd.restore', $pwd->id)}}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="w-full text-left p-2 text-sm text-green-500 flex gap-x-3 items-center hover:bg-gray-100 cursor-pointer"
                                        >
                                            <span>
                                                <img src="{{asset('/images/icons/reset.svg')}}" alt="" class="object-contain w-4 h-4">
                                            </span>
                                            Restore
                                        </button>
                                    </form>

                                    <form 
                                        action="{{route('pwd.destroy', $pwd->id)}}" 
                                        method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this PWD member?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="w-full text-left p-2 text-sm text-red-500 flex gap-x-3 items-center hover:bg-gray-100 cursor-pointer"
                                        >
                                            <span>
                                                <img src="{{asset('/images/icons/delete.svg')}}" alt="" class="object-contain w-4 h-4">
                                            </span>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                
                                
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
            <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                <thead class="text-gray-600 uppercase text-xs border-b">
                    <tr class="bg-gray-50">
                        <th class="p-3">ID NO.</th>
                        <th class="p-3">FULL NAME</th>
                        <th class="p-3">BIRTHDATE</th>
                        <th class="p-3">ADDRESS</th>
                        <th class="p-3">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $senior)
                        <tr class="border-b hover:bg-gray-100">

                            <td class="p-3">{{$senior->osca_id_number}}</td>

                            <td class="p-3 uppercase">
                               {{$senior->beneficiary->first_name}} {{$senior->beneficiary->middle_name ?? " "}} {{$senior->beneficiary->last_name}} 
                            </td>
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->format('m-d-Y') }}
                            </td>

                            <td class="p-3">
                                <h1 class="text-md uppercase">{{$senior->beneficiary->address->street->barangay->name}}</h1>
                                <p class="text-xs">{{$senior->beneficiary->address->street->name}} St.</p>
                            </td>

                            <td class="p-3 text-sm relative">
                                <!-- Button -->
                                <button class="archive-more-action-btn cursor-pointer hover:bg-gray-200 rounded-full p-1">
                                    <img src="{{ asset('/images/icons/more-action.svg') }}" class="w-5 h-5">
                                </button>

                                <!-- Dropdown -->
                                <div class="archive-more-action-wrapper hidden absolute right-5 top-10 w-30 bg-white rounded-lg shadow-lg z-50">
                                    <form action="{{route('senior.restore', $senior->id)}}" method="POST">
                                        @csrf
                                        <button 
                                            type="submit" 
                                            class="w-full text-left p-2 text-sm text-green-500 flex gap-x-3 items-center hover:bg-gray-100 cursor-pointer"
                                        >
                                            <span>
                                                <img src="{{asset('/images/icons/reset.svg')}}" alt="" class="object-contain w-4 h-4">
                                            </span>
                                            Restore
                                        </button>
                                    </form>

                                    <form 
                                        action="{{route('senior.destroy', $senior->id)}}" 
                                        method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this PWD member?')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="w-full text-left p-2 text-sm text-red-500 flex gap-x-3 items-center hover:bg-gray-100 cursor-pointer"
                                        >
                                            <span>
                                                <img src="{{asset('/images/icons/delete.svg')}}" alt="" class="object-contain w-4 h-4">
                                            </span>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                                
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
                                No result found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
    




@endsection