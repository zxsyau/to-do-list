@extends('layout.master')
@section('title', 'Assign Worker to task | Tasker ToDo')
@section('content')
    <div class="flex flex-col items-center min-h-screen bg-gray-50 mt-10 px-25">
        <div class="bg-white shadow-md rounded-lg p-6 w-full">
            <h1 class="text-2xl font-bold mb-2">Assign Worker to Task</h1>
        </div>
        <div class="bg-white shadow-md rounded-lg p-6 w-full mt-10">
            <form action="{{ route('postAssign', ['id' => $task->id]) }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <p class="text-gray-700 font-semibold mb-2">Pilih Worker:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($workers as $worker)
                            <label class="flex items-center bg-gray-50 p-3 rounded-md shadow-sm hover:bg-blue-50 transition">
                                <input type="checkbox" name="worker_ids[]" value="{{ $worker->id }}"
                                    class="mr-3 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                    {{ in_array($worker->id, $assignedWorkerIds) ? 'checked' : '' }}>
                                <span class="text-gray-800 text-sm font-medium">
                                    {{ $worker->name }} <span class="text-gray-500">({{ $worker->username }})</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="text-right">
                    <button type="submit"
                        class="bg-indigo-500 text-white font-semibold px-6 py-2 rounded hover:bg-indigo-600 transition">
                        Simpan
                    </button>
                </div>
            </form>

        </div>
    </div>
    </div>
@endsection
