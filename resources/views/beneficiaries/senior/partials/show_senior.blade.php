<div class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center">
    
    <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-[70%] rounded shadow p-5 overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="w-full flex justify-between items-center px-5 sticky top-[-20px] bg-white">
            <span class="font-bold text-2xl text-[#172373]"><u>Senior Citizen Information</u></span>

            <button class="text-[40px] cursor-pointer" data-close-modal data-type="senior">
                &times;
            </button>
        </div>

        <!-- PERSONAL INFORMATION -->
        <div class="w-full flex flex-col gap-y-5 mt-5">

            <div class="w-full bg-[#C3252B] px-5 py-1">
                <span class="text-white text-xl font-bold">Personal Information</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-5">

                <div class="flex flex-col gap-y-1 lg:col-span-3">
                    <label>Full Name:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="full_name"></span>
                </div> 

                <div class="flex flex-col gap-y-1">
                    <label>Date of Birth:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold" data-type="senior" data-field="birthdate"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Contact Number:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="contact_number"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Gender:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="gender"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Civil Status:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="civil_status"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Employment Status:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="employment_status"></span>
                </div>  
            </div>
        </div>


        <!-- ADDRESS INFORMATION -->
        <div class="w-full flex flex-col gap-y-5 mt-8">

            <div class="w-full bg-[#C3252B] px-5 py-1">
                <span class="text-white text-xl font-bold">Address Information</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-5">

                <div class="flex flex-col gap-y-1">
                    <label>House Number:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="house_num"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Barangay:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="barangay"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Street:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="street"></span>
                </div>  

            </div>
        </div>

        <!-- Senior citizen INFORMATION -->
        <div class="w-full flex flex-col gap-y-5 mt-8">

            <div class="w-full bg-[#C3252B] px-5 py-1">
                <span class="text-white text-xl font-bold">Senior Citizen Information</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-5">

                <div class="flex flex-col gap-y-1">
                    <label>OSCA ID Number:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="osca_id_number"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>NCSC Registration Number:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="ncsc_registration_number">N/A</span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Place of birth:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="place_of_birth"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Occupation:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="occupation"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Pension Amount:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] uppercase font-semibold" data-type="senior" data-field="pension_amount"></span>
                </div> 

                <div class="flex flex-col gap-y-1">
                    <label>Date ID issued:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold" data-type="senior" data-field="date_id_issued"></span>
                </div> 

            </div>
        </div>

        <!-- Family Members -->
        <div class="w-full flex flex-col gap-y-5 mt-8">

            <div class="w-full bg-[#C3252B] px-5 py-1">
                <span class="text-white text-xl font-bold">Family Members</span>
            </div>

            <div class="px-5">
                <table class="w-full text-sm text-left border-collapse bg-white shadow-md">
                    <thead class="text-gray-600 uppercase text-xs bg-[#F0F0F0] border-b">
                        <tr class="bg-gray-50">
                            <th class="p-3">FULL NAME</th>
                            <th class="p-3">RELATIONSHIP</th>
                            <th class="p-3">BIRTHDATE</th>
                            <th class="p-3">CIVIL STATUS</th>
                            <th class="p-3">OCCUPATION</th>
                        </tr>
                    </thead>
                    <tbody id="family-members-container" class="uppercase">
                        <!-- JS will insert rows here -->
                    </tbody>
                </table>
            </div>
        </div>




    </div>
</div>