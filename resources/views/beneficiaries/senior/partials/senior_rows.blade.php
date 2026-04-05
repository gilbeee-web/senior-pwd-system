
@forelse($senior_beneficiaries as $senior)
    <tr>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->osca_id_number}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$senior->beneficiary->last_name}} {{$senior->beneficiary->first_name}} </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->format('F d, Y') }}</td>
        
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$senior->beneficiary->address->street->name}} St.
        </td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$senior->beneficiary->address->street->barangay->name}}
        </td>
        
        <td class="px-4 py-2 text-sm border flex items-center justify-center gap-x-3">

            <button 
                class="view-btn text-blue-500 hover:underline mr-2"
                data-id="{{ $senior->id }}"
                data-type="senior"
                data-show-url="{{ url('senior/') }}/"
            >
                View
            </button>

            <a href="{{route('senior.edit', $senior->id)}}" class="text-blue-500 hover:underline mr-2">
                Edits
            </a>
            

            {{-- if super admin allowed both delete and archive --}}

            @if($current_user->role === 'super_admin')

                <form action="{{route('pwd.archive', $senior->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to archive this Senior Citizen member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">
                        {{-- <img src="{{ asset('assets/table_icons/deleteBtn.svg') }}" alt="" class="object-contain w-[20px] h-[20px] cursor-pointer"> --}}
                        Archive
                    </button>
                </form>

                <form action="{{route('pwd.destroy', $senior->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this Senior Citizen member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">
                        {{-- <img src="{{ asset('assets/table_icons/deleteBtn.svg') }}" alt="" class="object-contain w-[20px] h-[20px] cursor-pointer"> --}}
                        Delete
                    </button>
                </form>

            @else
                <form action="{{route('pwd.archive', $senior->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this Senior Citizen member?')">
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
        <td colspan="6" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse