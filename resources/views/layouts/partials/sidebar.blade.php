@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside class="w-64 shadow-md bg-white min-h-screen">

    <div class="px-3 py-1 font-bold text-lg shadow-sm flex gap-x-3 items-center bg-[#C3252B]">
        @if(auth()->user()->role === 'super_admin')
            <img src="{{asset('images/mswd-logo.png')}}" alt="home_icon" class="h-[40px] w-[40px] object-contain">
            <h1 class="text-white">MSWD</h1> 
        @elseif(auth()->user()->role === 'pwd_admin' || auth()->user()->role === 'barangay_pwd_admin')
            <img src="{{asset('images/logo/pdao.png')}}" alt="home_icon" class="h-[40px] w-[40px] object-contain">
            <h1 class="text-white">PDAO</h1> 
        @elseif(auth()->user()->role === 'senior_admin' || auth()->user()->role === 'barangay_senior_admin')
            <img src="{{asset('images/logo/osca.png')}}" alt="home_icon" class="h-[40px] w-[40px] object-contain">
            <h1 class="text-white">OSCA</h1> 
        @endif
    </div>

    <nav class="p-4 space-y-2">

        {{-- Dashboard --}}
        @if(auth()->user()->role === 'super_admin')
            <a 
                href="{{ route('super_admin.dashboard') }}" 
                class="block p-2 rounded flex gap-x-3 items-center
                {{ request()->routeIs('super_admin.dashboard') 
                    ? 'bg-red-500 text-white hover:bg-red-400' 
                    : 'hover:bg-gray-100' }}"
            >
                <span>
                    <img 
                        src="{{ request()->routeIs('super_admin.dashboard') 
                            ? asset('/images/icons/dashboard-alt.svg') 
                            : asset('/images/icons/dashboard.svg') }}" 
                        class="h-6 w-6 object-contain" 
                        alt="">
                </span> 
                Dashboard
            </a>
        @elseif(auth()->user()->role === 'barangay_pwd_admin' || auth()->user()->role === 'pwd_admin')
            <a 
                href="{{route('pwd_admin.dashboard')}}" 
                class="block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center
                {{ request()->routeIs('pwd_admin.dashboard') 
                    ? 'bg-red-500 text-white hover:bg-red-400' 
                    : 'hover:bg-gray-100' }}"
            >
               <span>
                    <img src="{{ request()->routeIs('pwd_admin.dashboard') 
                            ? asset('/images/icons/dashboard-alt.svg') 
                            : asset('/images/icons/dashboard.svg') }}" 
                        class="h-6 w-6 object-contain" alt=""
                    >
                </span>
                Dashboard
            </a>
        @elseif(auth()->user()->role === 'barangay_senior_admin' || auth()->user()->role === 'senior_admin')
            <a 
                href="{{route('senior_admin.dashboard')}}" 
                class="block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center
                {{ request()->routeIs('senior_admin.dashboard') 
                    ? 'bg-red-500 text-white hover:bg-red-400' 
                    : 'hover:bg-gray-100' }}"
            >
               <span>
                    <img src="{{ request()->routeIs('senior_admin.dashboard') 
                            ? asset('/images/icons/dashboard-alt.svg') 
                            : asset('/images/icons/dashboard.svg') }}" 
                    class="h-6 w-6 object-contain" alt="">
                </span>
                Dashboard
            </a>
        @endif

        {{-- Beneficiaries (shared) --}}
        @if(auth()->user()->role === 'super_admin')
            <a 
                href="{{route('beneficiary.index')}}" 
                class="
                    block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center
                    @if(request()->routeIs('beneficiary.*') || request()->routeIs('pwd.*') || request()->routeIs('senior.*')) 
                        bg-red-500 text-white hover:bg-red-400 
                    @endif
                " 
            >
                <span>
                    <img src="{{ request()->routeIs('beneficiary.*') || request()->routeIs('pwd.*') || request()->routeIs('senior.*')
                            ? asset('/images/icons/beneficiaries-alt.svg') 
                            : asset('/images/icons/beneficiaries.svg') }}" class="h-6 w-6 object-contain" alt="">
                </span> 
                Beneficiaries
            </a>
        @else
            <a 
                href="{{ route('beneficiary.index', [
                    'tab' => 
                        in_array(Auth::user()->role, ['barangay_senior_admin','senior_admin']) 
                        ? 'senior' 
                        : 'pwd'
                ]) }}"
                class="
                    block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center
                    @if(request()->routeIs('beneficiary.*') || request()->routeIs('pwd.*') || request()->routeIs('senior.*')) 
                        bg-red-500 text-white hover:bg-red-400 
                    @endif
                "
            >
               <span>
                    <img src="{{ request()->routeIs('beneficiary.*') || request()->routeIs('pwd.*') || request()->routeIs('senior.*')
                        ? asset('/images/icons/beneficiaries-alt.svg') 
                        : asset('/images/icons/beneficiaries.svg') }}" class="h-6 w-6 object-contain" alt=""
                    >
                </span>  Beneficiaries
            </a>
        @endif
       

        {{-- Reports --}}
        @if(auth()->user()->role === 'super_admin')
            <a 
                href="{{route('report.index')}}" 
                class="block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center
                    @if(request()->routeIs('report.*')) 
                        bg-red-500 text-white hover:bg-red-400 
                    @endif
                "
            >
                <span>
                    <img 
                        src="{{ request()->routeIs('report.*') 
                        ? asset('/images/icons/report-alt.svg') 
                        : asset('/images/icons/report.svg') }}" 
                        class="h-6 w-6 object-contain" alt=""
                    >
                </span> Reports
            </a>
        @else
            <a 
                href="{{ route('report.index', [
                    'tab' => 
                        in_array(Auth::user()->role, ['barangay_senior_admin','senior_admin']) 
                        ? 'senior' 
                        : 'pwd'
                ]) }}"
                class="
                    block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center 
                    @if(request()->routeIs('report.*')) 
                        bg-red-500 text-white hover:bg-red-400 
                    @endif
                "
            >
                <span>
                    <img 
                        src="{{ request()->routeIs('report.*') 
                        ? asset('/images/icons/report-alt.svg') 
                        : asset('/images/icons/report.svg') }}" 
                        class="h-6 w-6 object-contain" alt=""
                    >
                </span> Reports
            </a>
        @endif

        {{-- Requests --}}
        @if(auth()->user()->role === 'super_admin' || auth()->user()->role === 'senior_admin' || auth()->user()->role === 'pwd_admin')
            <a 
                href="{{route('request.index')}}" 
                class="block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center
                    @if(request()->routeIs('request.*')) 
                        bg-red-500 text-white hover:bg-red-400 
                    @endif
                "
            >
                <span>
                    <img src="{{ request()->routeIs('request.*') 
                        ? asset('/images/icons/request-alt.svg') 
                        : asset('/images/icons/request.svg') }}" class="h-6 w-6 object-contain" alt="">
                </span>
                Requests
            </a>
        @endif

        {{-- Super Admin --}}
        @if(auth()->user()->role === 'super_admin')
            <a 
                href="{{route('user.index')}}" 
                class="block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center @if(request()->routeIs('user.*')) bg-red-500 text-white hover:bg-red-400 @endif"
            >
            
                <span>
                    <img src="{{ request()->routeIs('user.index') 
                        ? asset('/images/icons/user-management-alt.svg') 
                        : asset('/images/icons/user-management.svg') }}" class="h-6 w-6 object-contain" alt="">
                </span>
                User Management
            </a>

            <a 
                href="{{route('settings.index')}}" 
                class="block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center @if(request()->routeIs('settings.*')) bg-red-500 text-white hover:bg-red-400 @endif"
            >
                <span>
                    <img src="{{ request()->routeIs('settings.index') 
                        ? asset('/images/icons/settings-alt.svg') 
                        : asset('/images/icons/settings.svg') }}" class="h-6 w-6 object-contain" alt="">
                </span>
                Settings
            </a>
        @endif

        @if(auth()->user()->role !== 'super_admin')
            <a 
                href="{{route('user.edit', auth()->user()->id)}}" 
                class="block p-2 rounded hover:bg-gray-100 flex gap-x-3 items-center @if(request()->routeIs('user.*')) bg-red-500 text-white hover:bg-red-400 @endif"
            >
            
               <span><img src="{{asset('/images/icons/user-management.svg')}}" class="h-6 w-6 object-contain" alt=""></span> Account Settings
            </a>

            <form action="{{route('user.logout')}}" method="POST" class="block p-2 rounded hover:bg-gray-100 cursor-pointer">
                @csrf
                <button class="flex gap-x-2 items-center">
                    <span class="object-contain w-6 h-6"><img src="{{asset('/images/icons/logout.svg')}}" alt=""></span> 
                    Logout
                </button>
            </form>
        @endif

        

    </nav>
</aside>
