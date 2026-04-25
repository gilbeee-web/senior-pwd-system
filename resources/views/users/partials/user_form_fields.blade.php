@php
    $isEditingOtherUser = false;
    $isOwnAccount = false;
    

    if(isset($user)){
        if($current_user->id !== $user->id && $mode === 'edit'){
            $isEditingOtherUser = true;
        }

        if($current_user->id === $user->id && $mode === 'edit'){
            $isOwnAccount = true;
        }
    }

    $profileImage = null;

    if($isEditingOtherUser && $user?->profile_pic){
        $profileImage = asset('storage/' . $user->profile_pic);
    } elseif($isOwnAccount && $current_user?->profile_pic){
        $profileImage = asset('storage/' . $current_user->profile_pic);
    } else {
        $profileImage = asset('images/default-profile.jpg');
    }

@endphp



{{-- <div class="mb-3">
    <label>Profile Picture</label>
    <input type="file" name="profile_pic"
        class="border p-2 rounded-lg @error('profile_pic') border-red-500 @enderror">
    @error('profile_pic')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div> --}}

<div class="flex gap-x-10 mt-5 items-center">

    <div class="relative inline-block">

        <!-- PROFILE BUTTON -->
        <button type="button" id="profile-btn" class="relative w-32 h-32 rounded-full bg-[#D9D9D9] cursor-pointer">

            
            <img 
                src="{{$profileImage}}" 
                alt="Profile"
                id="profile-img"
                class="w-full h-full object-cover rounded-full"
            >
           
            <!-- CAMERA ICON -->
            <div class="absolute -bottom-1 -right-1 bg-[#D9D9D9] rounded-full shadow border border-white z-10 p-3">
                <img src="{{ asset('images/camera-icon.png') }}" class="w-5 h-5 object-contain">
            </div>

        </button>

        

        <!-- FILE INPUT -->
        <input type="file" class="hidden" name="profile_pic" id="profile-file" accept="image/*"/>

        @error('profile_pic')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>

    <div class="flex flex-col gap-y-10">
        @if($mode === 'create' || ($current_user->role === 'super_admin' && $isEditingOtherUser))
        
            <div class="flex gap-x-10 items-center">
                <div class="flex flex-col gap-y-1">

                    <label for="">Full Name:</label>
                    <input 
                        type="text" 
                        placeholder="Enter full name..." 
                        name="name" 
                        class="border rounded-md p-2 bg-[#F5F5F5] @error('name') border-red-500 @enderror"
                        value="{{ old('name', $user->name ?? '') }}"
                        required
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>
                
                
                <div class="flex flex-col gap-y-1">

                    <label for="">Role:</label>
                    <select name="role" id="role"
                        class="border rounded-md p-2 bg-[#F5F5F5] @error('role') border-red-500 @enderror"
                    >
                        <option value="" disabled selected hidden>Select</option>

                        <option value="super_admin"
                            {{ old('role', $user->role ?? '') == 'super_admin' ? 'selected' : '' }}
                        >
                            Municipal Admin
                        </option>

                        <option value="pwd_admin"
                            {{ old('role', $user->role ?? '') == 'pwd_admin' ? 'selected' : '' }}>
                            PWD Admin
                        </option>

                        <option value="senior_admin"
                            {{ old('role', $user->role ?? '') == 'senior_admin' ? 'selected' : '' }}>
                            Senior Admin
                        </option>

                        <option value="barangay_pwd_admin"
                            {{ old('role', $user->role ?? '') == 'barangay_pwd_admin' ? 'selected' : '' }}>
                            Barangay Admin (PWD)
                        </option>

                        <option value="barangay_senior_admin"
                            {{ old('role', $user->role ?? '') == 'barangay_senior_admin' ? 'selected' : '' }}>
                            Barangay Admin (Senior Citizen)
                        </option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>  


                <div class="flex flex-col gap-y-1 hidden" id="barangay-wrapper">

                    <label for="">Barangay:</label>
                    <select name="barangay_id"
                        class="border rounded-md p-2 bg-[#F5F5F5] @error('barangay_id') border-red-500 @enderror"
                    >
                        <option value="" disabled selected hidden>Select</option>
                        @foreach($barangays as $brgy)
                            <option value="{{ $brgy->id }}"
                                {{ old('barangay_id', $user->barangay_id ?? '') == $brgy->id ? 'selected' : '' }}>
                                {{ $brgy->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('barangay_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

            </div>
        @endif

        @if($mode === 'edit')
            <div class="w-[40%] flex flex-col gap-y-1">

                <label for="">Change Username:</label>
                <input 
                    type="text"
                    name="username"
                    class="border p-2 rounded-lg @error('username') border-red-500 @enderror"
                    value="{{ old('username', $user->username ?? '') }}"
                    placeholder="Enter username..."
                >
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div>

        {{-- @else
            <div class="w-[35%] flex flex-col gap-y-1">

                <label for="">Username:</label>
                <input 
                    type="text" 
                    name="username"
                    class="border p-2 rounded-lg @error('username') border-red-500 @enderror"
                    value="{{ old('username', $user->username ?? '') }}"
                    placeholder="Enter username..."
                >
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

            </div> --}}
        @endif

        
        @if($isOwnAccount)
            <div class="flex gap-x-10 items-center">
                <div class="flex flex-col gap-y-1">

                    <label for="">Current password:</label>
                    <input 
                        type="password" 
                        name="current_password"
                        placeholder="" 
                        class="border rounded-md p-2 bg-[#F5F5F5] @error('current_password') border-red-500 @enderror"
                        required
                    >
                    @error('current_password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>


                <div class="flex flex-col gap-y-1">

                    <label for="">New password:</label>
                    <input 
                        type="password" 
                        name="password"
                        placeholder="" 
                        class="border rounded-md p-2 bg-[#F5F5F5] @error('password') border-red-500 @enderror"
                        required
                    >
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

                <div class="flex flex-col gap-y-1">

                    <label for="">Confirm new password:</label>
                    <input 
                        type="password" 
                        name="password_confirmation"
                        placeholder="" 
                        class="border rounded-md p-2 bg-[#F5F5F5] @error('password_confirmation') border-red-500 @enderror"
                        required
                    >
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror

                </div>

            </div>
        @endif

    </div>
    
</div>









