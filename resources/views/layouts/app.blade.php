<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>


    

    <div class="flex min-h-screen">
        
        {{-- sidebar --}}
        @include('layouts.partials.sidebar')

        {{-- main Content --}}
        <div class="flex-1 flex flex-col">

            @include('layouts.partials.navbar', ['title' => trim($__env->yieldContent('title'))])

            {{-- content --}}
            <main class="p-6">
                @yield('content')
            </main>

        </div>

    </div>

    
</body>
</html>