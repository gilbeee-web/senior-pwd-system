
@forelse($pwd_beneficiaries as $pwd)
    <tr>
        <td class="px-4 py-2 text-center border">
            <input 
                type="checkbox" 
                class="row-checkbox"
                name="selected_pwds[]"
                value="{{ $pwd->id }}"
            >
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->pwd_id_number}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->last_name}} {{$pwd->beneficiary->first_name}} </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{ \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('F d, Y') }}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->gender}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->disability_type}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$pwd->beneficiary->address->street->name}} {{$pwd->beneficiary->address->street->barangay->name}}
        </td>
        
        <td class="px-4 py-2 text-sm border flex items-center justify-center gap-x-3">

            <button 
                class="view-pwd-btn text-blue-500 hover:underline mr-2"
                data-pwd-id="{{ $pwd->id }}"
                data-show-url="{{ url('pwd/') }}/"
            >
                View
            </button>

            <a href="{{route('pwd.edit', $pwd->id)}}" class="text-blue-500 hover:underline mr-2">
                Edit
            </a>
            

            {{-- if super admin allowed both delete and archive --}}

            @if($current_user->role === 'super_admin')

                <form action="{{route('pwd.archive', $pwd->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this PWD member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">
                        {{-- <img src="{{ asset('assets/table_icons/deleteBtn.svg') }}" alt="" class="object-contain w-[20px] h-[20px] cursor-pointer"> --}}
                        Archive
                    </button>
                </form>

                <form action="{{route('pwd.destroy', $pwd->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this PWD member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">
                        {{-- <img src="{{ asset('assets/table_icons/deleteBtn.svg') }}" alt="" class="object-contain w-[20px] h-[20px] cursor-pointer"> --}}
                        Delete
                    </button>
                </form>

            @else
                <form action="{{route('pwd.archive', $pwd->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this PWD member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">
                        {{-- <img src="{{ asset('assets/table_icons/deleteBtn.svg') }}" alt="" class="object-contain w-[20px] h-[20px] cursor-pointer"> --}}
                        Delete
                    </button>
                </form>
            @endif

            


        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse