@forelse($employees as $employee)
    <tr class="border-b hover:bg-gray-200">
        <td class="p-3">{{$employee->full_name}}</td>

        <td class="p-3">{{ ucwords(str_replace('_', ' ', $employee->position)) }}</td>

        <td class="p-3">
            {{ ucwords(str_replace('_', ' ', $employee->role)) }}
        </td>

        <td class="p-3">
            @if($employee->is_active)
                Active
            @else
                Inactive
            @endif
        </td>

        <td class="px-4 py-2 text-sm relative">

            <!-- Button -->
            <button class="authorize-more-action-btn cursor-pointer hover:bg-gray-200 rounded-full p-1">
                <img src="{{ asset('/images/icons/more-action.svg') }}" class="w-5 h-5">
            </button>

            <!-- Dropdown -->
            <div class="authorize-more-action-wrapper hidden absolute right-1 top-10 w-30 bg-white rounded-lg shadow-lg z-50">
                <a href="{{route('settings.edit', $employee->id)}}" class="w-full text-left p-2 text-sm hover:bg-gray-100 flex gap-x-3 items-center cursor-pointer">
                   <span>
                        <img src="{{asset('/images/icons/edit.svg')}}" alt="" class="object-contain w-4 h-4">
                    </span> 
                    Edit
                </a>

                <form action="{{route('settings.updateStatus', $employee->id)}}" method="POST">
                    @csrf
                    @method('PUT')

                    <button type="submit" class="cursor-pointer flex gap-x-2 items-center p-2">
                        @if($employee->is_active)
                            <span>
                                <img src="{{asset('/images/icons/deactivate.svg')}}" alt="" class="object-contain w-4 h-4">
                            </span> 
                            Deactivate
                        @else
                            <span>
                                <img src="{{asset('/images/icons/activate.svg')}}" alt="" class="object-contain w-5 h-5">
                            </span> 
                            Activate
                        @endif
                    </button>
                    
                </form>

                <form action="{{route('settings.destroy', $employee->id)}}" method="POST" onsubmit="return confirm('Delete this employee?')">
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
            No employee found.
        </td>
    </tr>
@endforelse