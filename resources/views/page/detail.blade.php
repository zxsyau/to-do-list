@extends('layout.master')
@section('title', 'Detail Job | ToDo')
@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gray-50 mt-10 px-25">
        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <div class="flex justify-between">
                <h1 class="text-2xl font-bold mb-2">{{ $job->title }}</h1>
                <a class="border" href="{{ route('dashboard') }}">Back</a>
                <div class="flex justify-between">
                    @if (auth()->user()->role == 'tasker' || auth()->id() == $job->user_id)
                        <a href="{{ route('editJob', ['id' => $job->id]) }}"
                            class="bg-yellow-400 text-white px-4 py-2 rounded hover:bg-yellow-500 mr-1.5">✏️ Edit Job</a>
                        <form action="{{ route('deleteJob', ['id' => $job->id]) }}" method="POST"
                            onsubmit="return confirm('Yakin mau hapus task ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 hover:underline text-white px-4 py-2 rounded">🗑️
                                Delete</button>
                        </form>
                    @endif
                </div>
            </div>
            <h1 class="text-md mb-4 max-h-32 hover:overflow-y-scroll">{{ $job->description }}</h1>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 w-full mt-10">
            <div class="min-w-[1000px]">
                <div class="flex justify-between mb-3">
                    <h1 class="text-2xl font-bold mb-2">Task List</h1>
                    @if (auth()->user()->id == $job->user_id)
                        <a href="{{ route('createTask', ['job_id' => $job->id]) }}"
                            class="bg-indigo-500 text-white text-md rounded-md px-3 pb-0">+</a>
                    @endif
                </div>

                <table class="w-full border table-fixed">
                    <thead class="bg-gray-100 text-left">
                        <tr>
                            <th class="px-4 py-2 border w-1/4 text-center truncate">Title</th>
                            <th class="px-4 py-2 border w-1/4 text-center truncate">Description</th>
                            @if (auth()->user()->role == 'worker')
                                <th class="px-4 py-2 border w-1/4 text-center truncate">Status</th>
                            @endif
                            <th class="px-4 py-2 border w-1/4 text-center truncate">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($task) --}}
                        @foreach ($task as $item)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-2 border truncate">{{ $item->title }}</td>
                                            <td class="px-4 py-2 border truncate">{{ $item->description }}</td>
                                            @if (auth()->user()->role == 'worker')
                                                                <td class="px-4 py-2 border text-center truncate">
                                                                    {{-- Status --}}
                                                                    @php
                                                                        $userTask = \App\Models\UserTask::where('task_id', $item->id)
                                                                            ->where('user_id', auth()->id())
                                                                            ->first();
                                                                    @endphp

                                                                    @if ($userTask && $userTask->completed_at)
                                                                        <span class="text-green-600 font-semibold ml-2">✅ Done!</span>
                                                                    @else
                                                                        <span class="text-red-600 font-semibold ml-2">❌ Not done</span>
                                                                    @endif
                                                                </td>
                                            @endif
                                            <td class="px-4 py-2 border text-center space-x-2 truncate">
                                                @if (auth()->user()->role == 'tasker' || auth()->id() == $job->user_id)
                                                <a href="{{ route('detailTask', ['id' => $item->id]) }}"
                                                    class="text-blue-500 hover:underline">👁️ View</a>
                                                    <a href="{{ route('editTask', ['id' => $item->id]) }}"
                                                        class="text-yellow-500 hover:underline">✏️Edit</a>
                                                    <form action="{{ route('deleteTask', ['id' => $item->id]) }}" method="POST"
                                                        onsubmit="return confirm('Yakin mau hapus task ini?')" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:underline">🗑️ Delete</button>
                                                    </form>
                                                @endif
                                                @if (auth()->user()->role == 'worker')
                                                    <a href="{{ route('uploadProof', ['id' => $item->id]) }}"
                                                        class="text-indigo-500 hover:underline">🗃️ Proof</a>
                                                @endif
                                            </td>
                                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
