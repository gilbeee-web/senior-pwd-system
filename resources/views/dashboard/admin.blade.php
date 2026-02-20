<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    <form action="{{route('user.logout')}}" method="POST" class="flex items-center gap-3 hover:text-red-400 transition hover-logout">
        @csrf
        <button type="submit">Logout</button>
    </form>

    <h1>WELCOME BARANGAY ADMIN</h1>

</body>
</html>