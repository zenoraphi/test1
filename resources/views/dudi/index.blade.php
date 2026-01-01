@extends('layouts.app')

@section('title', 'Data DUDI')

@section('content')

{{-- ================= HEADER ================= --}}
<div class="mb-6 animate-slide-down">
    <div class="greeting-card rounded-2xl shadow-lg p-6 md:p-8">
        <div>
            <h1 class="text-3xl md:text-4xl font-bold mb-1">
                Data DUDI
            </h1>
            <p class="text-white/80 text-sm">
                Dunia Usaha dan Dunia Industri
            </p>
        </div>
    </div>
</div>

{{-- ================= STATISTIK ================= --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

    <div class="bg-white rounded-2xl shadow-md p-6">
        <p class="text-gray-500 text-sm">Total DUDI</p>
        <p class="text-3xl font-bold">
            {{ $dudis->total() }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6">
        <p class="text-gray-500 text-sm">Total Daya Tampung</p>
        <p class="text-3xl font-bold">
            {{ $dudis->sum('daya_tampung') }}
        </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6">
        <p class="text-gray-500 text-sm">Rata-rata Daya Tampung</p>
        <p class="text-3xl font-bold">
            {{ $dudis->count() ? round($dudis->avg('daya_tampung')) : 0 }}
        </p>
    </div>

</div>

{{-- ================= TABEL ================= --}}
<div class="bg-white rounded-2xl shadow-md p-6">

    {{-- SEARCH + TAMBAH --}}
    <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-4">

        <form method="GET" class="flex gap-2 w-full md:w-2/3">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari nama atau alamat DUDI..."
                class="w-full border rounded-lg px-4 py-2"
            >
            <button class="bg-primary text-white px-4 py-2 rounded-lg">
                Cari
            </button>
        </form>

        <a href="{{ route('dudi.create') }}"
           class="bg-primary text-white px-5 py-3 rounded-xl shadow hover:bg-blue-600 transition">
            + Tambah DUDI
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left">Nama DUDI</th>
                    <th class="px-4 py-3">Pimpinan</th>
                    <th class="px-4 py-3">Pembimbing Industri</th>
                    <th class="px-4 py-3">Jabatan</th>
                    <th class="px-4 py-3 text-center">Daya Tampung</th>
                    <th class="px-4 py-3 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
            @forelse($dudis as $dudi)
                <tr
                    onclick="window.location='{{ route('dudi.show', $dudi->id_dudi) }}'"
                    class="border-b hover:bg-gray-50 transition cursor-pointer">

                    <td class="px-4 py-3 font-semibold">
                        {{ $dudi->nama }}
                        <p class="text-xs text-gray-500">
                            {{ $dudi->alamat }}
                        </p>
                    </td>

                    <td class="px-4 py-3">
                        {{ $dudi->pimpinan ?? '-' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $dudi->pembimbing_dudi }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $dudi->jabatan ?? '-' }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-xs">
                            {{ $dudi->daya_tampung }}
                        </span>
                    </td>

                    {{-- AKSI --}}
                    <td class="px-4 py-3 text-center" onclick="event.stopPropagation()">
                        <div class="flex justify-center gap-2">

                            <a href="{{ route('dudi.edit', $dudi->id_dudi) }}"
                               class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-xs"
                               title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>

                            <form action="{{ route('dudi.destroy', $dudi->id_dudi) }}"
                                  method="POST">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="button"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs delete-btn"
                                    title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        Data DUDI belum tersedia
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- PAGINATION --}}
    <div class="mt-4">
        {{ $dudis->withQueryString()->links() }}
    </div>

</div>

{{-- ================= SWEETALERT DELETE ================= --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.stopPropagation();
        const form = this.closest('form');

        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data DUDI akan dihapus permanen',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

@endsection
