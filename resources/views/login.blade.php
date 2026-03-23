<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Senior PWD System</title>
        @vite(['resources/css/app.css', 'resources/js/login.js'])
    </head>
    <body 
        class="bg-cover bg-center min-h-screen flex items-center justify-center"
        style="background-image: url('{{ asset('images/mswd-bg.png') }}');"
    >
        

        <div class="p-5 shadow-md rounded-lg bg-white w-80">

            <h1 class="text-4xl font-bold mb-4">Login</h1>

            <form 
                action="{{route('user.login')}}" 
                method="POST" 
                class="flex flex-col gap-5"
                id="login-form"
            >
                
                @csrf
                

                <div class="w-full flex flex-col gap-2">
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
                <button 
                    class="w-full bg-[#ED4040] text-white p-2 rounded hover:bg-red-700 cursor-pointer"
                    id="login-btn"
                >
                    Login
                </button>


            </form>
        </div>



    </body>
</html>
