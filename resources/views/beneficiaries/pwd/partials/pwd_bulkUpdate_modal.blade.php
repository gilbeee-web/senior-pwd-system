<div 
    class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center"
>
    <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-[30%] rounded shadow px-5 overflow-y-auto max-h-[90vh]">

        <div class="w-full flex justify-between items-center">
            <span class="font-bold text-2xl text-[#172373]"><u>Validate PWD</u></span>

            <button class="close-bulk-modal-btn text-[40px] cursor-pointer" data-type="pwd">
                &times;
            </button>
        </div>


        <form 
            method="POST" action="{{route('pwd.validate')}}" 
            class="bulk-update-form w-full flex flex-col justify-center py-3"
            data-type="pwd"
        >
            @csrf

            <div class="border-b pb-2">
                <h1 class="text-xl font-semibold">Resident Status</h1>

                <div class="flex gap-x-5 mt-2">
                    <div class="flex items-center gap-x-2">
                        <input type="radio" name="resident_action" id="pwd_active_resident" value="active" class="w-5 h-5">
                        <label for="pwd_active_resident">Active Resident</label>
                    </div>

                    <div class="flex items-center gap-x-2">
                        <input type="radio" name="resident_action" id="pwd_inactive_resident" value="inactive" class="w-5 h-5">
                        <label for="pwd_inactive_resident">Transferred</label>
                    </div>
                </div>
            </div>

            <div class="mt-5 border-b pb-2">
                <h1 class="text-xl font-semibold">Status</h1>

                <div class="flex gap-x-5 mt-2">
                    <div class="flex items-center gap-x-2">
                        <input type="radio" name="status_action" value="alive" id="pwd_alive" class="w-5 h-5">
                        <label for="pwd_alive">Alive</label>
                    </div>

                    <div class="flex items-center gap-x-2">
                        <input type="radio" name="status_action" value="deceased" id="pwd_deceased" class="w-5 h-5">
                        <label for="pwd_deceased">Deceased</label>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <h1 class="text-xl font-semibold">Income</h1>

                <div class="flex gap-x-5 mt-2">
                    <div class="flex items-center gap-x-2">
                        <input type="radio" name="income_action" value="below" id="below_income" class="w-5 h-5">
                        <label for="below_income">Below 8k (Not Middle Class)</label>
                    </div>

                    <div class="flex items-center gap-x-2">
                        <input type="radio" name="income_action" value="above" id="above_income" class="w-5 h-5">
                        <label for="above_income">Above 8k (Middle Class)</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="mt-5 bg-blue-500 hover:bg-blue-300 text-white text-lg rounded-lg p-3 cursor-pointer">Apply</button>
        </form>
    </div>
</div>