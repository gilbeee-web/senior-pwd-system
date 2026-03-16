
@forelse($users as $user)
    <tr>
        <td class="px-4 py-2 text-sm text-gray-800 border font-bold">{{$loop->iteration}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border font-bold">{{$user->name}}</td>
        <td class="px-4 py-2 text-sm text-gray-800 border font-bold">{{$user->username}}</td>

        @if($user->role === 'barangay_pwd_admin' || $user->role === 'barangay_senior_admin')
            <td class="px-4 py-2 text-sm text-gray-800 border font-bold">{{$user->barangay}} Admin</td>
        @else
            <td class="px-4 py-2 text-sm text-gray-800 border font-bold">Municipal Admin</td>
        @endif
        
        <td class="px-4 py-2 text-sm border border-gray-400 flex items-center justify-center gap-x-3">

            <a href="{{route('user.edit', $user->id)}}" class="text-blue-500 hover:underline mr-2">
                Edit
            </a>


            {{-- the form submitted automatically in js, search for user-form.js --}}
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
                    {{-- <img src="{{ asset('assets/table_icons/deleteBtn.svg') }}" alt="" class="object-contain w-[20px] h-[20px] cursor-pointer"> --}}
                    Delete
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="3" class="text-center py-4 text-gray-500 text-[34px] font-extrabold">
            No users found.
        </td>
    </tr>
    
@endforelse