@extends('layout.master')
@section('title', 'Task Detail | Tasker ToDo')
@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gray-50 mt-10 px-25">
        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <div class="flex justify-between mb-3">
                <h1 class="text-2xl font-bold mb-2">{{ $detailTask->title }}</h1>
                <a href="{{ route('assignWorker', ['id' => $detailTask->id]) }}"
                    class="bg-indigo-500 text-white text-md rounded-md p-3">Assign Worker</a>
            </div>
            <h1 class="text-md mb-4 max-h-32 hover:overflow-y-scroll">{{ $detailTask->description }}</h1>
            @if (auth()->user()->role == 'tasker')
                <div class="text-gray-700 font-medium">Assigned Workers:</div>
                <div class="col-span-2 text-gray-900">
                    @forelse ($detailTask->userTasks as $userTask)
                        <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs mr-2">
                            {{ $userTask->user->name }}
                        </span>
                    @empty
                        <span class="text-gray-400 italic">Belum ada worker</span>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
@endsection
