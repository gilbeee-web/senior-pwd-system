
@forelse($pwd_beneficiaries as $pwd)
    <tr class="border-b hover:bg-gray-100">
        <td class="p-3">
            <input 
                type="checkbox" 
                class="row-checkbox h-4 w-4"
                data-type="pwd"
                name="selected_pwds[]"
                value="{{ $pwd->id }}"
            >
        </td>
        <td class="p-3">{{$pwd->pwd_id_number}}</td>
        <td class="p-3 uppercase">{{$pwd->beneficiary->first_name}} {{$pwd->middle_name ?? ' '}} {{$pwd->beneficiary->last_name}}</td>
        <td class="p-3 uppercase">
            {{ \Carbon\Carbon::parse($pwd->beneficiary->birthdate)->format('m-d-Y') }}
        </td>
        <td class="p-3">
            <h1 class="text-md uppercase">{{$pwd->beneficiary->address->street->barangay->name}}</h1>
            <p class="text-xs">{{$pwd->beneficiary->address->street->name}} St.</p>
        </td>
        <td class="p-3 uppercase">{{$pwd->disability_type}}</td>
        <td class="p-3">
            {{ \Carbon\Carbon::parse($pwd->date_id_issued)->format('m-d-Y') }}
        </td>
        <td class="p-3">
            {{ \Carbon\Carbon::parse($pwd->date_id_expiration)->format('m-d-Y') }}
        </td>
        
        <td class="p-3 text-sm relative">

            <!-- Button -->
            <button class="pwd-more-action-btn cursor-pointer hover:bg-gray-200 rounded-full p-1">
                <img src="{{ asset('/images/icons/more-action.svg') }}" class="w-5 h-5">
            </button>

            <!-- Dropdown -->
            <div class="pwd-more-action-wrapper hidden absolute right-1 top-10 w-30 bg-white rounded-lg shadow-lg z-50">

                <div>
                    <button 
                        class="view-btn block p-2 text-sm hover:bg-gray-100 flex gap-x-3 items-center"
                        data-id="{{ $pwd->id }}"
                        data-type="pwd"
                        data-show-url="{{ url('pwd/') }}/"
                    >
                        <span>
                            <img src="{{asset('/images/icons/view.svg')}}" alt="" class="object-contain w-4 h-4">
                        </span>
                        View
                    </button>
                </div>
                
                <a href="{{route('pwd.edit', $pwd->id)}}" class="w-full text-left p-2 text-sm hover:bg-gray-100 flex gap-x-3 items-center cursor-pointer">
                   <span>
                        <img src="{{asset('/images/icons/edit.svg')}}" alt="" class="object-contain w-4 h-4">
                    </span> 
                    Edit
                </a>
                
                <form action="{{route('pwd.archive', $pwd->id)}}" method="POST" onsubmit="return confirm('Are you sure you want to delete this PWD member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full text-left p-2 text-sm text-red-500 flex gap-x-3 items-center hover:bg-gray-100 cursor-pointer">
                        <span>
                            <img src="{{asset('/images/icons/archive.svg')}}" alt="" class="object-contain w-4 h-4">
                        </span>
                        Archive
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