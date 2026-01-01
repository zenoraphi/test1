@extends('layouts.app')
@section('title', 'Detail DUDI')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="mb-6 animate-slide-down">
    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold mb-1">
                    {{ $dudi->nama }}
                </h1>
                <p class="text-white/80 text-sm">
                    Detail Dunia Usaha & Dunia Industri
                </p>
            </div>

            <a href="{{ route('dudi.index') }}"
                class="bg-white text-primary px-5 py-3 rounded-xl shadow
                    hover:bg-blue-50 transition">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>
</div>

<div class="container mx-auto space-y-6">

    {{-- ================= INFORMASI DUDI ================= --}}
    <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 animate-scale-fade">
        <h2 class="text-xl font-bold mb-4">Informasi DUDI</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
            <p><b>Nama DUDI:</b> {{ $dudi->nama }}</p>
            <p><b>Pimpinan:</b> {{ $dudi->pimpinan ?? '-' }}</p>
            <p><b>Pembimbing Industri:</b> {{ $dudi->pembimbing_dudi }}</p>
            <p><b>Jabatan Industri:</b> {{ $dudi->jabatan ?? '-' }}</p>
            <p><b>Alamat:</b> {{ $dudi->alamat }}</p>
            <p><b>Daya Tampung:</b> {{ $dudi->daya_tampung }} siswa</p>
        </div>
    </div>

    {{-- ================= SISWA PKL ================= --}}
    <div class="bg-white rounded-2xl shadow-md p-6 md:p-8 animate-scale-fade">
        <h2 class="text-xl font-bold mb-4">
            Siswa PKL di DUDI Ini
        </h2>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-3">No</th>
                        <th class="px-3 py-3">Nama</th>
                        <th class="px-3 py-3">Kelas</th>
                        <th class="px-3 py-3">Jurusan</th>
                        <th class="px-3 py-3">Pembimbing Sekolah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dudi->siswas as $siswa)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-3 py-2">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2 font-semibold">{{ $siswa->nama }}</td>
                            <td class="px-3 py-2">{{ $siswa->kelas }}</td>
                            <td class="px-3 py-2">
                                {{ $siswa->jurusan->jurusan ?? '-' }}
                            </td>
                            <td class="px-3 py-2">
                                {{ $siswa->pembimbing->nama ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-500">
                                Belum ada siswa PKL di DUDI ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@endsection
