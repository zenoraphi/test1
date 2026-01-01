@extends('layouts.app')

@section('title', 'Detail Jurusan')

@section('content')
<div class="bg-white rounded-xl shadow p-6 max-w-xl">
    <h1 class="text-2xl font-bold mb-4">Jurusan</h1>

    <div class="border rounded-lg p-4 bg-gray-50">
        <p class="text-gray-600 text-sm">Nama Jurusan</p>
        <p class="text-lg font-semibold text-gray-900">
            {{ $jurusan->jurusan }}
        </p>
    </div>
</div>
@endsection
