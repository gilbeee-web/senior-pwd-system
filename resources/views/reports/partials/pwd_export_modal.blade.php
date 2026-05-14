<div class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center">
    
    <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-[25%] rounded shadow p-5 overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="w-full flex justify-between items-center sticky top-[-20px] bg-white">
            <span class="font-bold text-lg text-[#172373]"><u>Select Column to Export</u></span>

            <button class="text-[30px] cursor-pointer close-export-modal">
                &times;
            </button>
        </div>

        <div class="mt-5">
            <form action="{{ route('report.pwd.export') }}" method="GET" class="export-form">

                <input type="hidden" name="barangay" value="{{ request('barangay') }}">
                <input type="hidden" name="disability_type" value="{{ request('disability_type') }}">
                <input type="hidden" name="gender" value="{{ request('gender') }}">
                <input type="hidden" name="civil_status" value="{{ request('civil_status') }}">
                <input type="hidden" name="educational_attainment" value="{{ request('educational_attainment') }}">
                <input type="hidden" name="employment_status" value="{{ request('employment_status') }}">
                <input type="hidden" name="min_age" value="{{ request('min_age') }}">
                <input type="hidden" name="max_age" value="{{ request('max_age') }}">

                <div
                    class="flex flex-col gap-y-3"
                >
                    <!-- SELECT ALL -->
                    <div class="border-b pb-2">
                        <label class="flex items-center gap-2 font-semibold">
                            <input type="checkbox" class="select-all h-5 w-5">
                            Select All
                        </label>
                    </div>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="pwd_id_number" checked class="h-5 w-5">
                        ID Number
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="name" checked class="h-5 w-5">
                        Name
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="birthdate" checked class="h-5 w-5">
                        Birthdate
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="disability_type" checked class="h-5 w-5">
                        Disability Type
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="gender" checked class="h-5 w-5">
                        Gender
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="street" checked class="h-5 w-5">
                        Street
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="barangay" checked class="h-5 w-5">
                        Barangay
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="civil_status" class="h-5 w-5">
                        Civil Status
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="employment_status" class="h-5 w-5">
                        Employment Status
                    </label>

                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="columns[]" value="educational_attainment" class="h-5 w-5">
                        Educational Attainment
                    </label>
                </div>
                
 
                <div class="mt-5 w-full flex justify-end">
                    <button 
                        type="submit" 
                        class="export-btn text-white hover:bg-green-300 bg-green-500 p-2 rounded-lg cursor-pointer"
                    >
                        Export Excel
                    </button>
                </div>  
                
            </form> 
        </div>


    </div>

</div>