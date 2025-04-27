<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <title>login | ToDo</title>
</head>

<body class="bg-indigo-900 flex flex-col min-h-screen items-center justify-center">
    <form action="{{ route('postLogin') }}" method="POST">
        @csrf
        <div class="w-100 h-full bg-white flex flex-col p-10 rounded-md shadow-lg">
            <h1 class="text-center text-2xl font-bold">Selamat Datang di ToDo</h1>
            <h2 class="text-center text-sm text-gray-500">Silahkan masuk dengan akun anda!</h2>
            <label for="username" class="mt-5">Username</label>
            <input type="text" name="username" placeholder="Masukan username anda" class="border-2 border-gray-300 rounded-md p-2 outline-none">
            <label for="password" class="mt-5">Password</label>
            <input type="text" name="password" placeholder="Masukan password anda" class="border-2 border-gray-300 rounded-md p-2  outline-none">
            <button type="submit" class="bg-indigo-700 hover:bg-indigo-900  text-white rounded-md p-2 mt-5">Masuk</button>
            @if ($errors->any())
                    <p class="text-red-500 text-center">{{ $errors->first() }}</p>
            @endif
        </div>
    </form>
</body>

</html>
