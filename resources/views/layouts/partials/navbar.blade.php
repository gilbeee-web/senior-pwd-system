<header class="bg-white shadow px-6 py-4 flex justify-between items-center">

    <div class="font-semibold text-lg">
         {{ $title ?? 'Dashboard' }}  
    </div>

    <div class="flex items-center gap-4">

        <span class="text-sm text-gray-600">
            {{ auth()->user()->name }}
        </span>

        <form action="{{route('user.logout')}}" method="POST" class="flex items-center gap-3 hover:text-red-400 transition hover-logout">
            @csrf
            <button type="submit">Logout</button>
        </form>
        

    </div>
</header>