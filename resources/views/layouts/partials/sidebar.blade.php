@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside class="w-64 shadow-md bg-white min-h-screen">

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
        @elseif(auth()->user()->role === 'barangay_pwd_admin')
            <a href="{{route('barangay_pwd_admin.dashboard')}}" class="block p-2 rounded hover:bg-gray-100">
                Dashboard
            </a>
        @endif

        {{-- Beneficiaries (shared) --}}
       
        <a 
            href="{{route('beneficiary.index')}}" 
            class="
                block p-2 rounded hover:bg-gray-100 
                @if(request()->routeIs('beneficiary.*') || request()->routeIs('pwd.*') || request()->routeIs('senior.*')  ) 
                    bg-red-500 text-white hover:bg-red-400 
                @endif
            " 
        >
            Beneficiaries
        </a>
       

        {{-- Reports --}}
        <a 
            href="{{route('report.index')}}" 
            class="block p-2 rounded hover:bg-gray-100
                @if(request()->routeIs('report.*')) 
                    bg-red-500 text-white hover:bg-red-400 
                @endif
            "
        >
            Reports
        </a>

        {{-- Super Admin --}}
        @if(auth()->user()->role === 'super_admin')
            <a 
                href="{{route('user.index')}}" 
                class="block p-2 rounded hover:bg-gray-100 @if(request()->routeIs('user.*')) bg-red-500 text-white hover:bg-red-400 @endif"
            >
            
                User Management
            </a>
        @endif

    </nav>
</aside>
