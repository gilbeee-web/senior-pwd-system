
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
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->disability_type}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">{{$pwd->beneficiary->address->street->name}} St.</td>
        <td class="px-4 py-2 text-sm text-gray-800 border">
            {{$pwd->beneficiary->address->street->barangay->name}}
        </td>
        
        <td class="px-4 py-2 text-sm border flex items-center justify-center gap-x-3">

            <button 
                class="view-btn text-blue-500 hover:underline mr-2"
                data-id="{{ $pwd->id }}"
                data-type="pwd"
                data-show-url="{{ url('pwd/') }}/"
            >
                View
            </button>

            <a href="{{route('pwd.edit', $pwd->id)}}" class="text-blue-500 hover:underline mr-2">
                Edit
            </a>
            
            <form action="{{route('pwd.archive', $pwd->id)}}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this PWD member?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:underline">
                    Archive
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