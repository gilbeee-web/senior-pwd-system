<div class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center">
    
    <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-[70%] rounded shadow p-5 overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="w-full flex justify-between items-center px-5 sticky top-[-20px] bg-white">
            <span class="font-bold text-2xl text-[#172373]"><u>Review Changes</u></span>

            <button class="close-modal-btn text-[40px] cursor-pointer">
                &times;
            </button>
        </div>

        <div class="space-y-2 mt-5">
            <table class="w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-3 py-2 text-left">Field</th>
                        <th class="border px-3 py-2 text-left">Old Value</th>
                        <th class="border px-3 py-2 text-left">New Value</th>
                    </tr>
                </thead>

                <tbody id="changes-container">
                    <!-- JS injects rows here -->
                </tbody>
            </table>
        </div>

        
        <div class="w-full mt-10 flex justify-end items-center" id="approve-submit-field">
            <div class="flex gap-x-5">
                <button
                    class="close-modal-btn p-3 bg-[#DFDFDF] text-[#787878] rounded-md cursor-pointer shadow-lg" 
                >
                    Cancel
                </button>

                <button 
                    class="p-3 bg-green-500 hover:bg-green-300 text-white rounded-md shadow-lg cursor-pointer" 
                    type="submit"
                    id="approve-changes-btn"
                >
                    Approve
                </button>
            </div>
        </div>

    </div>

</div>