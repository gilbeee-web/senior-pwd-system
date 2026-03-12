<header class="w-full flex justify-between items-center bg-[#C3252B] shadow sticky top-0 z-10 hidden lg:flex">

    <h1 class="ml-5 text-white text-lg font-bold">
        {{ $title ?? 'Dashboard' }}
    </h1>

    <!-- Account Menu Wrapper -->
    <div class="relative">

        <button 
            class="flex items-center gap-x-4 bg-white rounded-l-full px-5 cursor-pointer"
            id="accountSettings-btn"
        >
            <div class="flex flex-col items-center">
                <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                <p class="text-gray-500 text-sm">Admin</p>
            </div>

            <img src="{{auth()->user()->profile_pic ?? asset('images/default-profile.jpg')}}" 
                 class="object-contain w-10 rounded-full">
        </button>

        <!-- Dropdown -->
        <div id="accountSettings-dropdown"
            class="hidden absolute right-0 w-[200px] bg-white rounded-lg shadow-lg rounded-bl-4xl"
        >

            <a href="{{route('user.edit', auth()->user()->id)}}"
                class="px-4 py-2 hover:bg-gray-100 w-full flex justify-center">
                Account Settings
            </a>

            <form action="{{route('user.logout')}}" method="POST" class="w-full flex justify-center hover:bg-gray-100">
                @csrf
                <button class="text-left px-4 py-2 cursor-pointer">
                    Logout
                </button>
            </form>

        </div>

    </div>

</header>