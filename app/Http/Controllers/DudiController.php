<?php

namespace App\Http\Controllers;

use App\Models\Dudi;
use Illuminate\Http\Request;

class DudiController extends Controller
{
    /**
     * INDEX
     * daftar semua DUDI
     */
    public function index(Request $request)
    {
        $dudis = Dudi::when($request->search, function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->search . '%')
                ->orWhere('alamat', 'like', '%' . $request->search . '%');
        })
            ->orderBy('nama')
            ->paginate(10);

        return view('dudi.index', compact('dudis'));
    }

    /**
     * CREATE
     * form tambah DUDI
     */
    public function create()
    {
        return view('dudi.create');
    }

    /**
     * STORE
     * simpan DUDI baru
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'            => 'required|string|max:255',
            'alamat'          => 'required|string',
            'pimpinan'        => 'nullable|string|max:255',
            'pembimbing_dudi' => 'required|string|max:255',
            'jabatan'         => 'nullable|string|max:255',
            'daya_tampung'    => 'required|integer|min:0',
        ]);

        Dudi::create($data);

        return redirect()
            ->route('dudi.index')
            ->with('success', 'Data DUDI berhasil ditambahkan');
    }

    /**
     * SHOW
     * detail DUDI + siswa + pembimbing + jurusan
     */
    public function show(Dudi $dudi)
    {
        $dudi->load([
            'siswas.pembimbing',
            'siswas.jurusan',
        ]);

        return view('dudi.show', compact('dudi'));
    }

    /**
     * EDIT
     */
    public function edit(Dudi $dudi)
    {
        return view('dudi.edit', compact('dudi'));
    }

    /**
     * UPDATE
     */
    public function update(Request $request, Dudi $dudi)
    {
        $data = $request->validate([
            'nama'            => 'required|string|max:255',
            'alamat'          => 'required|string',
            'pimpinan'        => 'nullable|string|max:255',
            'pembimbing_dudi' => 'required|string|max:255',
            'jabatan'         => 'nullable|string|max:255',
            'daya_tampung'    => 'required|integer|min:0',
        ]);

        $dudi->update($data);

        return redirect()
            ->route('dudi.index')
            ->with('success', 'Data DUDI berhasil diperbarui');
    }

    /**
     * DESTROY
     */
    public function destroy(Dudi $dudi)
    {
        $dudi->delete();

        return redirect()
            ->route('dudi.index')
            ->with('success', 'Data DUDI berhasil dihapus');
    }
}
