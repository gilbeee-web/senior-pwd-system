<div class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center">
    
    <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-[70%] rounded shadow p-5 overflow-y-auto max-h-[90vh]">

        <!-- HEADER -->
        <div class="w-full flex justify-between items-center px-5 sticky top-[-20px] bg-white">
            <span class="font-bold text-2xl text-[#172373]"><u>PWD Information</u></span>

            <button class="text-[40px] cursor-pointer" data-close-modal data-type="pwd">
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
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="full_name"></span>
                </div> 

                <div class="flex flex-col gap-y-1">
                    <label>Date of Birth:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold" data-type="pwd" data-field="birthdate"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Contact Number:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold" data-type="pwd" data-field="contact_number"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Gender:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="gender"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Civil Status:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="civil_status"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Employment Status:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="employment_status"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Educational Attainment:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="educational_attainment"></span>
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
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold" data-type="pwd" data-field="house_num"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Barangay:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="barangay"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Street:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="street"></span>
                </div>  

            </div>
        </div>


        <!-- PWD INFORMATION -->
        <div class="w-full flex flex-col gap-y-5 mt-8">

            <div class="w-full bg-[#C3252B] px-5 py-1">
                <span class="text-white text-xl font-bold">PWD Information</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 px-5">

                <div class="flex flex-col gap-y-1">
                    <label>PWD ID Number:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold" data-type="pwd" data-field="pwd_id_number"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Disability Type:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="disability_type"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Guardian Name:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold uppercase" data-type="pwd" data-field="guardian_name"></span>
                </div>  

                <div class="flex flex-col gap-y-1">
                    <label>Blood Type:</label>
                    <span class="rounded-md p-2 bg-[#F5F5F5] font-semibold" data-type="pwd" data-field="blood_type"></span>
                </div>  

            </div>
        </div>

    </div>

</div>