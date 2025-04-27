@extends('layout.master')
@section('title', 'Create Task | ToDo')
@section('content')
    <div class="flex flex-col min-h-screen items-center justify-center">
        <form method="POST" action="{{ route('postTask', ['job_id' => $job->id]) }}">
            @csrf
            <div class="w-200 max-h-300 bg-white flex flex-col p-10 rounded-md shadow-lg">
                <h1 class="text-center text-2xl font-bold">Create Task</h1>
                <label for= "title" class="mt-5">Title</label>
                <input type="text" name="title" placeholder="Masukan title anda"
                    class="border-2 border-gray-300 rounded-md p-2 outline-none">

                <label for="description" class="mt-5">Description</label>
                <textarea name="description" id="description"
                    class=" h-100 max-h-500 border-2 border-gray-300 rounded-md p-2 outline-none hover:overflow-y-scroll"></textarea>

                <button type="submit" class="bg-indigo-500 text-white rounded-md p-2 mt-5">Create</button>
                @if ($errors->any())
                    <p class="text-red-500 text-center">{{ $errors->first() }}</p>
                @endif
            </div>
        </form>
    </div>
@endsection
