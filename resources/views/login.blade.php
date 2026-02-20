<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Senior PWD System</title>
        @vite('resources/css/app.css')
    </head>
    <body class="text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
        
        
        

        <div class="p-5 shadow-md border">

            <h1 class="text-3xl font-bold mb-4">Login Page</h1>

            <form action="{{route('user.login')}}" method="POST" class="flex flex-col gap-5">
                
                @csrf
                

                <div class="flex flex-col gap-2">
                  <label class="block text-sm mb-1">Username:</label>
                  <input 
                    type="text" 
                    name="username" 
                    class="w-full border rounded p-2 focus:outline-none focus:ring"
                    value="{{old('username')}}"
                    required
                  >

                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>


                <div class="flex flex-col gap-2">
                  <label class="block text-sm mb-1">Password:</label>
                  <input 
                    type="password" 
                    name="password" 
                    class="w-full border rounded p-2 focus:outline-none focus:ring"
                    value="{{old('password')}}"
                    required
                  >

                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror

                </div>


                {{-- Remember --}}
                <div class="mb-4 flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <label class="text-sm">Remember me</label>
                </div>
                
                {{-- Submit --}}
                <button class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700">
                    Login
                </button>


            </form>
        </div>



    </body>
</html>
