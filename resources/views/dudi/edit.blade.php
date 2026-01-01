@extends('layouts.app')

@section('title', 'Edit DUDI')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="mb-6 animate-slide-down">
    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold mb-1">
                Edit DUDI
            </h1>
            <p class="text-white/80 text-sm">
                Perbarui data Dunia Usaha & Dunia Industri
            </p>
        </div>
    </div>
</div>

{{-- ================= FORM ================= --}}
<div class="container mx-auto">
    <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 animate-scale-fade">

        <form action="{{ route('dudi.update', $dudi->id_dudi) }}"
              method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @csrf
            @method('PUT')

            {{-- Nama DUDI --}}
            <div>
                <label class="block font-semibold mb-1">Nama DUDI</label>
                <input
                    type="text"
                    name="nama"
                    value="{{ old('nama', $dudi->nama) }}"
                    required
                    class="form-input"
                >
            </div>

            {{-- Pimpinan --}}
            <div>
                <label class="block font-semibold mb-1">Pimpinan</label>
                <input
                    type="text"
                    name="pimpinan"
                    value="{{ old('pimpinan', $dudi->pimpinan) }}"
                    class="form-input"
                >
            </div>

            {{-- Pembimbing Industri --}}
            <div>
                <label class="block font-semibold mb-1">Pembimbing Industri</label>
                <input
                    type="text"
                    name="pembimbing_dudi"
                    value="{{ old('pembimbing_dudi', $dudi->pembimbing_dudi) }}"
                    required
                    class="form-input"
                >
            </div>

            {{-- Jabatan Pembimbing Industri --}}
            <div>
                <label class="block font-semibold mb-1">Jabatan Pembimbing Industri</label>
                <input
                    type="text"
                    name="jabatan"
                    value="{{ old('jabatan', $dudi->jabatan) }}"
                    class="form-input"
                >
            </div>

            {{-- Daya Tampung --}}
            <div>
                <label class="block font-semibold mb-1">Daya Tampung</label>
                <input
                    type="number"
                    name="daya_tampung"
                    min="1"
                    value="{{ old('daya_tampung', $dudi->daya_tampung) }}"
                    required
                    class="form-input"
                >
            </div>

            {{-- Alamat --}}
            <div class="md:col-span-2">
                <label class="block font-semibold mb-1">Alamat</label>
                <textarea
                    name="alamat"
                    rows="3"
                    required
                    class="form-input"
                >{{ old('alamat', $dudi->alamat) }}</textarea>
            </div>

            {{-- ================= BUTTON ================= --}}
            <div class="md:col-span-2 flex justify-between items-center mt-6">

                <a href="{{ route('dudi.index') }}"
                   class="px-6 py-3 rounded-xl border font-semibold hover:bg-gray-100 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali
                </a>

                <div class="flex gap-3">
                    <a href="{{ route('dudi.index') }}"
                       class="px-6 py-3 rounded-xl border font-semibold hover:bg-gray-100 transition">
                        Batal
                    </a>

                    <button
                        type="submit"
                        class="bg-primary text-white px-6 py-3 rounded-xl font-semibold
                               hover:bg-primary/90 hover:scale-105 transition-all duration-300">
                        <i class="fas fa-save mr-2"></i> Update Data
                    </button>
                </div>

            </div>

        </form>
    </div>
</div>

@include('layouts.animation')

@endsection
