@extends('layout.master')
@section('title', 'Edit user | Admin ToDo')
@section('content')
    <div class="flex flex-col min-h-screen items-center justify-center">
        <form method="POST" action="{{ route('postEditUser', ['type' => $type, 'id' => $user->id]) }}">
            @csrf
            <div class="w-100 h-full bg-white flex flex-col p-10 rounded-md shadow-lg">
                <h1 class="text-center text-2xl font-bold">Edit User {{ Str::title($type) }}</h1>
                <label for="name" class="mt-5">Name</label>
                <input type="text" name="name" placeholder="Masukan name anda" value="{{ $user->name }}"
                    class="border-2 border-gray-300 rounded-md p-2 outline-none">

                <label for="username" class="mt-5">Username</label>
                <input type="text" name="username" placeholder="Masukan username anda" value="{{ $user->username }}"
                    class="border-2 border-gray-300 rounded-md p-2 outline-none">

                <label for="phone_number" class="mt-5">Phone Number</label>
                <input type="text" name="phone_number" placeholder="Masukan phone number anda" value="{{ $user->phone_number }}"
                    class="border-2 border-gray-300 rounded-md p-2 outline-none">


                <label for="password" class="mt-5">Password</label>
                <input type="text" name="password" placeholder="Masukan password anda"
                    class="border-2 border-gray-300 rounded-md p-2  outline-none">

                <input type="hidden" name="role" value="{{ $type }}">
                <button type="submit" class="bg-indigo-500 text-white rounded-md p-2 mt-5">Create</button>
                @if ($errors->any())
                    <p class="text-red-500 text-center">{{ $errors->first() }}</p>
                @endif
            </div>
        </form>
    </div>
@endsection
