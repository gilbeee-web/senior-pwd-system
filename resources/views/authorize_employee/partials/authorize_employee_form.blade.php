<div class="flex gap-x-10 items-center">
    <div class="flex flex-col gap-y-1">

        <label for="">Full Name: <span class="text-red-500">*</span></label>
        <input 
            type="text" 
            placeholder="Enter full name..." 
            name="full_name" 
            class="border rounded-md p-2 bg-[#F5F5F5] @error('name') border-red-500 @enderror"
            value="{{ old('full_name', $employee->full_name ?? '') }}"
            required
        >
        @error('full_name')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>

    <div class="flex flex-col gap-y-1">

        <label for="">Position:<span class="text-red-500">*</span></label>
        <input 
            type="text" 
            placeholder="Enter Position..." 
            name="position" 
            class="border rounded-md p-2 bg-[#F5F5F5] @error('name') border-red-500 @enderror"
            value="{{ old('position', $employee->position ?? '') }}"
            required
        >
        @error('position')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex flex-col gap-y-1">

        <label for="">Role:<span class="text-red-500">*</span></label>

        <select 
            name="role"
            class="border rounded-md p-2 bg-[#F5F5F5] @error('role') border-red-500 @enderror"
        >
            <option value="" disabled selected hidden>Select</option>

            <option value="mayor"
                {{ old('role', $employee->role ?? '') == 'mayor' ? 'selected' : '' }}
            >
                Mayor
            </option>

            <option value="senior_chairman"
                {{ old('role', $employee->role ?? '') == 'senior_chairman' ? 'selected' : '' }}
            >
                Senior Chairman
            </option>

            <option value="pwd_chairman"
                {{ old('role', $employee->role ?? '') == 'pwd_chairman' ? 'selected' : '' }}>
                PWD Chairman
            </option>
        </select>

        @error('role')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror

    </div>  



</div>