<div 
    class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center"
>
    <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-[30%] rounded shadow px-5 overflow-y-auto max-h-[90vh]">

        <div class="w-full flex justify-between items-center">
            <span class="font-bold text-2xl text-[#172373]"><u>Validate PWD</u></span>

            <button class="text-[40px] cursor-pointer" id="close-bulk-modal-btn">
                &times;
            </button>
        </div>


        <form id="bulk-update-form" method="POST" action="{{route('pwd.validate')}}" class="w-full flex flex-col justify-center py-3">
            @csrf

            <div>
                <p class="text-xl">Resident Status</p>
                <label><input type="radio" name="resident_action" value="active"> Active</label>
                <label><input type="radio" name="resident_action" value="inactive"> Not Active</label>
            </div>

          
            <div class="mt-5">
                <p class="text-xl">Status</p>
                <label><input type="radio" name="status_action" value="alive"> Alive</label>
                <label><input type="radio" name="status_action" value="deceased"> Deceased</label>
            </div>

            
            <div class="mt-5">
                <p class="text-xl">Income</p>
                <label><input type="radio" name="income_action" value="1"> Below 8k</label>
                <label><input type="radio" name="income_action" value="0"> Above 8k</label>
            </div>

            <button type="submit" class="mt-5 bg-blue-500 text-white text-lg rounded-lg p-3 cursor-pointer">Apply</button>
        </form>
    </div>
</div>