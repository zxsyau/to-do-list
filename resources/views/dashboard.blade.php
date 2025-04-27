@extends('layout.master')
@section('title', 'Dashboard')
@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gray-50 mt-10 px-25">
        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <div class="flex justify-between">
                <h1 class="text-2xl font-bold mb-4">Selamat datang, {{ auth()->user()->name }}</h1>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-white font-bold bg-red-700 px-3 py-2 rounded-md hover:bg-red-900">Logout</button>
                </form>
            </div>
            <div class="title">
                @if (auth()->user()->role == 'admin')
                    <p class="text-gray-700">Kelola user ToDo disini!</p>
                @elseif (auth()->user()->role == 'tasker')
                    <p class="text-gray-700">Kelola tugas yang anda berikan disini!</p>
                @else
                    <p class="text-gray-700">Kerjakan tugas yang diberikan disini!</p>
                @endif
            </div>
        </div>

        {{-- @if (Session::success)
            <p>{{ Session::success }}</p>
        @endif --}}

        @if (auth()->user()->role == 'admin')
            <div class="bg-white shadow-md rounded-lg p-6 w-full mt-10">
                <div class="grid grid-cols-2 gap-x-10 px-10">
                    <a href="{{ route('users', ['type' => 'tasker']) }}"
                        class="w-full h-35 border border-blue-900  bg-blue-100 hover:bg-blue-200 flex items-center justify-center text-center rounded-md text-2xl font-bold text-gray-900">Kelola
                        User Tasker</a>
                    <a href="{{ route('users', ['type' => 'worker']) }}"
                        class="w-full h-35 border border-blue-900 bg-blue-100 hover:bg-blue-200 flex items-center justify-center  text-center rounded-md text-2xl font-bold text-gray-900">Kelola
                        User Worker</a>
                </div>
            </div>
        @elseif (auth()->user()->role == 'tasker')
            <div class="bg-white shadow-md rounded-lg p-6 w-full mt-10">
                <div class="flex justify-between">
                    <h1 class="text-black text-2xl font-bold mb-5">Job List</h1>
                    <a href="{{ route('createJob') }}" class="bg-indigo-500 text-white text-md rounded-md p-3">+</a>
                </div>
                <div class="grid grid-cols-4 gap-2">
                    @foreach ($jobs as $j)
                        <a href="{{ route('detail', ['id' => $j->id]) }}"
                            class="w-full h-30 border border-blue-900  bg-blue-100 hover:bg-blue-200 flex items-center justify-center text-center rounded-md text-2xl font-bold text-gray-900">
                            {{ $j->title }}</a>
                    @endforeach
                </div>
            </div>
        @else
            {{-- role worker --}}
            {{-- dari tasker --}}
            <div class="bg-white shadow-md rounded-lg p-6 w-full mt-10">
                <div class="mb-10 rounded-xl shadow-md p-6">
                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Job List From Tasker</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @forelse ($taskerJobs as $item)
                            <a href="{{ route('detail', ['id' => $item->id]) }}"
                                class="bg-blue-100 shadow-md rounded-lg p-6 hover:bg-blue-200 transition-colors flex flex-col items-center text-center">
                                <h3 class="font-bold text-lg text-gray-800">{{ $item->title }}</h3>
                            </a>
                        @empty
                            <div class="col-span-4 text-center text-gray-500 italic">
                                Belum ada tugas dari Tasker.
                            </div>
                        @endforelse
                    </div>
                </div>

                {{-- Job worker sendiri --}}
                <div class="rounded-xl shadow-md p-6">
                    <div class="flex justify-between mb-4 items-center">
                        <h3 class="text-2xl font-bold text-gray-800">Job List From Me</h3>
                        <a href="{{ route('createJob') }}"
                            class="bg-indigo-500 text-white px-2 pb-1 rounded hover:bg-indigo-600 text-2xl">+
                        </a>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        @php
                            $myJobs = $jobs->filter(fn($job) => $job->user_id == Auth::id());
                        @endphp

                        @forelse ($myJobs as $item)
                            <a href="{{ route('detail', ['id' => $item->id]) }}"
                                class="bg-blue-100 shadow-md rounded-lg p-6 hover:bg-blue-200 transition-colors flex flex-col items-center text-center">
                                <h3 class="font-bold text-lg text-gray-800">{{ $item->title }}</h3>
                            </a>
                        @empty
                            <div class="col-span-4 text-center text-gray-500 italic">
                                Kamu belum punya Job pribadi. Yuk buat sekarang! 🎯
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
