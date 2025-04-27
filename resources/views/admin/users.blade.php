@extends('layout.master')
@section('title', 'User List | Admin ToDo')
@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gray-50 mt-10 px-25">
        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <div class="flex flex-col">
                <h1 class="text-2xl font-bold mb-4">User List - {{ Str::title($type) }}</h1>
                <div class="flex justify-between w-full">
                    <a href="{{ route('dashboard') }}" class="bg-indigo-500 text-white text-md rounded-md p-3">Back</a>
                    <a href="{{ route('createuser', ['type' => $type]) }}"
                    class="bg-indigo-500 text-white text-md rounded-md p-3">+ Create User</a>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6 w-full mt-10">
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase truncate w-85">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase truncate">
                            Username
                        </th>
                        <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase truncate">
                            Phone Number
                        </th>
                        <th class="px-6 py-3 text-left text-md font-medium text-gray-600 uppercase truncate w-70 ">
                            Action button
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-gray-100">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4">{{ $user->name }}</td>
                            <td class="px-6 py-4">{{ $user->username }}</td>
                            <td class="px-6 py-4">{{ $user->phone_number }}</td>
                            <td class="px-6 py-4">
                                <a href="" class="text-blue-500 mr-2 hover:underline">👁️View</a>
                                <a href="{{ route('edituser', ['id' => $user->id]) }}"
                                    class="text-yellow-500 hover:underline">✏️Edit</a>

                                <form action=" {{ route('postDeleteUser', ['id' => $user->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Are you sure you want to delete this user?')"
                                        class="text-red-500 rounded-md hover:underline">🗑️Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
