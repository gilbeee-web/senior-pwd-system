
@forelse($senior_beneficiaries as $senior)
    <tr class="border-b hover:bg-gray-100">
        <td class="h-10 p-3">
            <input 
                type="checkbox" 
                class="row-checkbox w-4 h-4"
                data-type="senior"
                name="selected_seniors[]"
                value="{{ $senior->id }}"
            >
        </td>
        <td class="p-3">{{$senior->osca_id_number}}</td>
        <td class="p-3 uppercase">
            {{$senior->beneficiary->first_name}} {{$senior->beneficiary->middle_name ?? ' '}}   {{$senior->beneficiary->last_name}}  
        </td>
        <td class="p-3">
            {{ \Carbon\Carbon::parse($senior->beneficiary->birthdate)->format('m-d-Y') }}
        </td>

        <td class="p-3">
            <h1 class="text-md uppercase">{{$senior->beneficiary->address->street->barangay->name}}</h1>
            <p class="text-xs">{{$senior->beneficiary->address->street->name}} St.</p>
        </td>
        
        <td class="p-3">
            {{ \Carbon\Carbon::parse($senior->date_id_issued)->format('m-d-Y') }}
        </td>

        <td class="p-3 text-sm relative">

            <!-- Button -->
            <button class="senior-more-action-btn cursor-pointer hover:bg-gray-200 rounded-full p-1">
                <img src="{{ asset('/images/icons/more-action.svg') }}" class="w-5 h-5">
            </button>

            <!-- Dropdown -->
            <div class="senior-more-action-wrapper hidden absolute right-1 top-10 w-30 bg-white rounded-lg shadow-lg z-50">

                <div>
                    <button 
                        class="view-btn block p-2 text-sm hover:bg-gray-100 flex gap-x-3 items-center"
                        data-id="{{ $senior->id }}"
                        data-type="senior"
                        data-show-url="{{ url('senior/') }}/"
                    >
                        <span>
                            <img src="{{asset('/images/icons/view.svg')}}" alt="" class="object-contain w-4 h-4">
                        </span>
                        View
                    </button>
                </div>
                
                <a href="{{route('senior.edit', $senior->id)}}" class="w-full text-left p-2 text-sm hover:bg-gray-100 flex gap-x-3 items-center cursor-pointer">
                   <span>
                        <img src="{{asset('/images/icons/edit.svg')}}" alt="" class="object-contain w-4 h-4">
                    </span> 
                    Edit
                </a>
                
                <form action="{{route('senior.archive', $senior->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this Senior Citizen member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-left p-2 text-sm text-red-500 flex gap-x-3 items-center hover:bg-gray-100 cursor-pointer">
                        <span>
                            <img src="{{asset('/images/icons/archive.svg')}}" alt="" class="object-contain w-4 h-4">
                        </span>
                        Archive
                    </button>
                </form>


                {{-- <button 
                    class="view-btn text-blue-500 hover:underline mr-2"
                    data-id="{{ $senior->id }}"
                    data-type="senior"
                    data-show-url="{{ url('senior/') }}/"
                >
                    View
                </button>

                <a href="{{route('senior.edit', $senior->id)}}" class="text-blue-500 hover:underline mr-2">
                    Edit
                </a>
                
                <form action="{{route('pwd.archive', $senior->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this Senior Citizen member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">
                        Archive
                    </button>
                </form> --}}
            
            </div>

            

            


        </td>
    </tr>
@empty
    <tr>
        <td colspan="6" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No result found.
        </td>
    </tr>
    
@endforelse