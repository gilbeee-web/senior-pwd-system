<aside class="w-64 shadow-md bg-white h-full">

    <div class="px-3 py-1 font-bold text-lg shadow-sm flex gap-x-3 items-center bg-[#C3252B]">
        <img src="{{asset('images/mswd-logo.png')}}" alt="home_icon" class="h-[40px] w-[40px] object-contain">
        <h1 class="text-white">MSWD</h1> 
    </div>

    <nav class="p-4 space-y-2">

        {{-- Dashboard --}}
        @if(auth()->user()->role === 'super_admin')
            <a href="{{route('super_admin.dashboard')}}" class="block p-2 rounded hover:bg-gray-100">
                Dashboard
            </a>
        @elseif(auth()->user()->role === 'barangay_admin')
            <a href="{{route('barangay_admin.dashboard')}}" class="block p-2 rounded hover:bg-gray-100">
                Dashboard
            </a>
        @endif

        {{-- Beneficiaries (shared) --}}
        @if(in_array(auth()->user()->role, ['super_admin','barangay_admin']))
            <a href="{{route('beneficiary.index')}}" class="block p-2 rounded hover:bg-gray-100">
                Beneficiaries
            </a>
        @endif

        {{-- Reports --}}
        @if(in_array(auth()->user()->role, ['super_admin','barangay_admin']))
            <a href="/reports" class="block p-2 rounded hover:bg-gray-100">
                Reports
            </a>
        @endif

        {{-- Super Admin --}}
        @if(auth()->user()->role === 'super_admin')
            <a href="{{route('user.index')}}" class="block p-2 rounded hover:bg-gray-100">
                User Management
            </a>
        @endif

    </nav>
</aside>
