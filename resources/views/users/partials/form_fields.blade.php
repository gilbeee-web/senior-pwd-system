<div class="mb-3">
    <label>Profile Picture</label>
    <input type="file" name="profile_pic" class="border p-2 rounded-lg">
</div>

@if($current_user->role === 'super_admin')
    <div class="mb-3">
        <label>Name:</label>
        <input type="text" name="name" class="border p-2 rounded-lg"
            value="{{ old('name', $user->name ?? '') }}">
    </div>



    <div class="mb-3">
        <label>Role:</label>
        <select name="role" id="role" class="border p-2 rounded-lg w-full">
            <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected': '' }}>
                Municipal Admin
            </option>
            <option value="barangay_admin" {{ old('role') == 'barangay_admin' ? 'selected': '' }}>
                Barangay Admin
            </option>
        </select>
    </div>

    <div class="mb-3" id="barangay-wrapper">
        <label>Barangay:</label>
        <select name="barangay_id" id="barangay" class="border rounded px-3 py-2">
            <option value="">-- Select Barangay --</option>
            @foreach($barangays as $brgy)
                <option value="{{ $brgy->id }}"
                    {{ old('barangay', $user->barangay_id ?? '') == $brgy->id ? 'selected' : '' }}>
                    {{ $brgy->name }}
                </option>
            @endforeach
        </select>
    </div>
@endif



@if($current_user->role === 'barangay_admin')

    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" class="border p-2 rounded-lg"
            value="{{ old('username', $user->username ?? '') }}">
    </div>


    <div class="mb-3">
        <label>Password {{ isset($user) ? '(leave blank to keep)' : '' }}</label>
        <input type="password" name="password" class="border p-2 rounded-lg">
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="border p-2 rounded-lg">
    </div>
@endif

