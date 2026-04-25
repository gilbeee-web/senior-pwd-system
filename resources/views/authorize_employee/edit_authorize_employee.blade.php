<div class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center">

   <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-4xl rounded shadow">
        <div class="flex justify-between items-center p-4 border-b">
            <h2 class="font-semibold text-lg">Update Authorize Employee</h2>
            <button class="text-2xl cursor-pointer" id="authorize-close-btn">&times;</button>
        </div>

        <form action="{{ route('settings.update', $employee->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
            @csrf
            @method('PUT')

            @include('authorize_employee.partials.authorize_employee_form')

            <div class="flex justify-end mt-4">
                <button type="submit" class="p-4 bg-blue-500 rounded-lg cursor-pointer text-white">Update</button>
            </div>
        </form>
   </div>
</div>