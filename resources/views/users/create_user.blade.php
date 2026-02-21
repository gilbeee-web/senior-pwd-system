<div class="fixed inset-0 bg-[rgba(0,0,0,0.5)] z-50 flex items-center justify-center hidden" id="user-form-wrapper">

    <div class="w-full bg-white sm:max-w-md md:max-w-2xl lg:max-w-5xl rounded shadow">

      
      <div class="flex justify-between items-center p-4 border-b">
         <h2 class="font-semibold text-lg">Create User</h2>
         <button class="text-2xl cursor-pointer" id="close-btn">&times;</button>
      </div>

      <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data" class="p-4">
         @csrf

         @include('users.partials.form_fields')

         <div class="flex justify-end mt-4">
               <button type="submit" class="p-4 bg-blue-500 rounded-lg cursor-pointer text-white">Create</button>
         </div>
      </form>

    </div>
</div>