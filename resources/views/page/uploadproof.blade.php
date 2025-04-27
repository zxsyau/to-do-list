@extends('layout.master')
@section('title', 'Upload Proof | Tasker ToDo')
@section('content')
    <div class="w-full bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-2xl font-bold text-[#0c1c38] mb-4">Upload Bukti Pengerjaan</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif


        {{-- Upload Form --}}
        <form action="{{ route('postProof', ['id' => $task->id]) }}" method="POST" enctype="multipart/form-data"
            class="space-y-4">
            @csrf
            <div>
                <label for="file_proof" class="block text-sm font-medium text-gray-700 mb-1">Pilih File (jpeg, png, jpg, docx,
                    xlsx, pdf, zip)
                    - Max 5MB</label>
                <input type="file" name="file_proof"
                    class="block w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                    required>
                @error('file_proof')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                class="w-full bg-indigo-500 text-white font-semibold py-2 px-4 rounded-full hover:bg-indigo-600 transition">
                Unggah Bukti Pengerjaan
            </button>
        </form>
        {{-- Preview File Sebelumnya --}}
        @if ($userTask && $userTask->file_proof)
            <div class="mt-6 pt-4 border-t">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Preview Bukti</h3>

                {{-- ngambil ekstensi dari path file --}}
                @php
                    $extension = pathinfo($userTask->file_proof, PATHINFO_EXTENSION);
                @endphp

                @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $userTask->file_proof) }}" alt="Proof Image"
                        class="w-full max-h-96 object-contain rounded shadow-md">
                @elseif ($extension === 'pdf')
                    <p class="text-blue-600">📄 File PDF:
                        <a href="{{ asset('storage/' . $userTask->file_proof) }}" target="_blank" class="underline">
                            Lihat File
                        </a>
                    </p>
                @else
                    <p class="text-gray-600">📁 File:
                        <a href="{{ asset('storage/' . $userTask->file_proof) }}" download class="underline">
                            {{-- ambil nama filenya aja dari path --}}
                            {{ basename($userTask->file_proof) }}
                        </a>
                    </p>
                @endif
            </div>
        @endif
    </div>
@endsection
