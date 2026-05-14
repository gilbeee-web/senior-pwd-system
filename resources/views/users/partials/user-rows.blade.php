
@forelse($users as $user)
    <tr class="border-b hover:bg-gray-200">
        <td class="p-3 uppercase">{{$user->name}}</td>

        <td class="p-3">{{$user->username}}</td>

        @if($user->role === 'barangay_pwd_admin')
            <td class="p-3">
                <h1 class="uppercase">PWD Admin</h1>
                <p>{{$user->barangay}}</p>
            </td>
        @elseif($user->role === 'barangay_senior_admin')
            <td class="p-3 uppercase">
                <h1 class="uppercase">Senior Admin</h1>
                <p>{{$user->barangay}}</p>
            </td>
        @elseif($user->role === 'pwd_admin')
            <td class="p-3 uppercase">PWD Admin</td>
        @elseif($user->role === 'senior_admin')
            <td class="p-3 uppercase">Senior Admin</td>
        @else
            <td class="p-3 uppercase">Municipal Admin</td>
        @endif

        <td class="p-3 relative">
    
            <!-- Button -->
            <button class="user-more-action-btn cursor-pointer hover:bg-gray-200 rounded-full p-1">
                <img src="{{ asset('/images/icons/more-action.svg') }}" class="w-5 h-5">
            </button>

            <!-- Dropdown -->
            <div class="user-more-action-wrapper hidden absolute right-8 top-12 w-35 bg-white rounded-lg shadow-lg z-50">
                <div>
                    <a href="{{ route('user.edit', $user->id) }}" 
                        class="block p-2 text-sm hover:bg-gray-100 flex gap-x-3 items-center"
                    >
                        <span>
                            <img src="{{asset('/images/icons/edit.svg')}}" alt="" class="object-contain w-4 h-4">
                        </span>
                        Edit
                    </a>
                </div>
                
                <form 
                    id="reset-password-form-{{ $user->id }}" 
                    action="{{ route('user.resetPassword', $user->id) }}" 
                    method="POST"
                >
                    @csrf
                    @method('PUT')
                    <button 
                        type="button"
                        class="reset-password-btn w-full text-left p-2 text-sm hover:bg-gray-100 flex gap-x-3 items-center cursor-pointer"
                        data-id="{{ $user->id }}"
                    >
                        <span>
                            <img src="{{asset('/images/icons/reset.svg')}}" alt="" class="object-contain w-4 h-4">
                        </span>
                        Reset Password
                    </button>
                </form>

                <form action="" method="POST" onsubmit="return confirm('Delete this user?')">
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
        
        {{-- <td class="px-4 py-2 text-sm border border-gray-400 flex items-center justify-center gap-x-3">
            <button class="user-more-action-btn cursor-pointer hover:bg-gray-200 rounded-full">
                <img src="{{asset('/images/icons/more-action.svg')}}" alt="More-action button" class="object-contain w-5 h-5">
            </button>

            <div class="hidden user-more-action-wrapper">
                <a href="{{route('user.edit', $user->id)}}" class="text-blue-500 hover:underline mr-2">
                    <img src="{{asset('/images/icons/edit.svg')}}" alt="Edit button" class="object-contain w-5 h-5">
                </a>

                <form id="reset-password-form-{{ $user->id }}"
                    action="{{ route('user.resetPassword', $user->id) }}"
                    method="POST"
                    style="display: none;">
                    @csrf

                    <input type="hidden" name="new_password" value="default123">
                    <input type="hidden" name="new_password_confirmation" value="default123">
                </form>

                <button 
                    type="button"
                    class="reset-password-btn text-blue-500 hover:underline mr-2"
                    data-id="{{ $user->id }}"
                >
                    Reset Password
                </button>

                <form action="" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-500 hover:underline">
                        {{-- <img src="{{ asset('assets/table_icons/deleteBtn.svg') }}" alt="" class="object-contain w-[20px] h-[20px] cursor-pointer"> 
                        Delete
                    </button>
                </form>
            </div>
            

           

            
        </td> --}}
    </tr>
@empty
    <tr>
        <td colspan="3" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No users found.
        </td>
    </tr>
    
@endforelse