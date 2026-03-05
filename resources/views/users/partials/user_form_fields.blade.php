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
@endphp



<div class="mb-3">
    <label>Profile Picture</label>
    <input type="file" name="profile_pic"
        class="border p-2 rounded-lg @error('profile_pic') border-red-500 @enderror">
    @error('profile_pic')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

{{-- When creating or editing other user show this input field (for super admin only) --}}
@if($mode === 'create' || ($current_user->role === 'super_admin' && $isEditingOtherUser))

    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name"
            class="border p-2 rounded-lg @error('name') border-red-500 @enderror"
            value="{{ old('name', $user->name ?? '') }}">
        @error('name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label>Role:</label>
        <select name="role" id="role"
            class="border p-2 rounded-lg w-full @error('role') border-red-500 @enderror">

            <option value="super_admin"
                {{ old('role', $user->role ?? '') == 'super_admin' ? 'selected' : '' }}
            >
                Municipal Admin
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

    <div class="mb-3" id="barangay-wrapper">
        <label>Barangay:</label>
        <select name="barangay_id"
            class="border rounded px-3 py-2 @error('barangay_id') border-red-500 @enderror">
            <option value="">-- Select Barangay --</option>
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
@endif


@if($mode === 'edit')
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username"
            class="border p-2 rounded-lg @error('username') border-red-500 @enderror"
            value="{{ old('username', $user->username ?? '') }}">
        @error('username')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
@endif



@if($isOwnAccount)

    <div class="mb-3">
        <label>Current password</label>
        <input type="password" name="current_password"
            class="border p-2 rounded-lg @error('current_password') border-red-500 @enderror">
        @error('current_password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label>New password</label>
        <input type="password" name="password" class="border p-2 rounded-lg">
        @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-3">
        <label>Confirm new password</label>
        <input type="password" name="password_confirmation" class="border p-2 rounded-lg">
        @error('password_confirmation')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>
@endif










