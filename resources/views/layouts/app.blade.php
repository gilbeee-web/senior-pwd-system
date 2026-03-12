<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-screen overflow-hidden">


    

    <div class="flex h-full">
        
        {{-- sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- main Content --}}
        <div class="flex-1 flex flex-col bg-[#DFDFDF]">

            @include('layouts.partials.navbar', ['title' => trim($__env->yieldContent('title'))])

            {{-- content --}}
            <main class="p-6 overflow-y-auto flex-1">
                @yield('content')
            </main>

        </div>

    </div>


    @if(session()->has('success') || session()->has('error') || session()->has('warning') || session()->has('info'))
        <script>
        document.addEventListener("DOMContentLoaded", function () {

            let icon = '';
            let message = '';

            @if(session('success'))
                icon = 'success';
                message = "{{ session('success') }}";
            @elseif(session('error'))
                icon = 'error';
                message = "{{ session('error') }}";
            @elseif(session('warning'))
                icon = 'warning';
                message = "{{ session('warning') }}";
            @elseif(session('info'))
                icon = 'info';
                message = "{{ session('info') }}";
            @endif

            Swal.fire({
                icon: icon,
                title: message,
                confirmButtonColor: '#2563eb'
            });

        });
        </script>
    @endif


    @if(session('generated_credentials'))
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const credentials = @json(session('generated_credentials'));

                Swal.fire({
                    title: 'Account Created Successfully!',
                    html: `
                        
                        <div style="text-align:left;">
                            <p>Please save this user crendentials. User will use this to login.</p>
                            <br>
                            <p><strong>Username:</strong> ${credentials.username}</p>
                            <p><strong>Password:</strong> ${credentials.password}</p>
                            <button id="copyBtn" class="swal2-confirm swal2-styled" style="margin-top:10px;">
                                Copy
                            </button>
                        </div>
                    `,
                    icon: 'success',
                    showConfirmButton: false
                });

                document.addEventListener('click', function(e) {
                    if (e.target && e.target.id === 'copyBtn') {
                        navigator.clipboard.writeText(
                            `Username: ${credentials.username}\nPassword: ${credentials.password}`
                        );
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: 'Copied!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });

            });
        </script>
    @endif


    

    
</body>
</html>