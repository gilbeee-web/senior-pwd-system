<aside class="w-64 bg-white shadow-md">
    <div class="p-4 font-bold text-lg border-b">
        Pension System
    </div>

    <nav class="p-4 space-y-2">

        {{-- Dashboard --}}
        <a href="/dashboard" class="block p-2 rounded hover:bg-gray-100">
            Dashboard
        </a>

        {{-- Super Admin --}}
        @if(auth()->user()->role === 'super_admin')
            <a href="/users" class="block p-2 rounded hover:bg-gray-100">
                User Management
            </a>
        @endif

        {{-- Beneficiaries (shared) --}}
        @if(in_array(auth()->user()->role, ['super_admin','admin']))
            <a href="/beneficiaries" class="block p-2 rounded hover:bg-gray-100">
                Beneficiaries
            </a>
        @endif

        {{-- Reports --}}
        @if(in_array(auth()->user()->role, ['super_admin','admin']))
            <a href="/reports" class="block p-2 rounded hover:bg-gray-100">
                Reports
            </a>
        @endif

    </nav>
</aside>
