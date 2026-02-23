<div class="flex justify-center items-center p-5 border">
    <h1>Account Settings</h1>

    <hr>
    <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        @method('put')

        @include('users.partials.form_fields')

        <div class="flex justify-end mt-4">
            <button type="submit" class="p-4 bg-blue-500 rounded-lg cursor-pointer text-white">Update</button>
        </div>
    </form>

</div>



