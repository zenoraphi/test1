@extends('layouts.app')

@section('title', 'Data Jurusan')

@section('content')
<div class="bg-white rounded-xl shadow p-6">
    <h1 class="text-2xl font-bold mb-6">Daftar Jurusan</h1>

    <ul class="space-y-3">
        @foreach ($jurusans as $jurusan)
            <li class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <span class="font-medium text-gray-800">
                    {{ $jurusan->jurusan }}
                </span>

                <a href="{{ route('jurusan.show', $jurusan->id_jurusan) }}"
                    class="text-blue-600 hover:underline">
                    Lihat
                </a>
            </li>
        @endforeach
    </ul>
</div>
@endsection
