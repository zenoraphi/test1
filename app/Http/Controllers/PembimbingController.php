<?php

namespace App\Http\Controllers;

use App\Models\Pembimbing;
use App\Models\Dudi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PembimbingController extends Controller
{
    public function index(Request $request)
    {
        $pembimbing = Pembimbing::with('dudis')
            ->when($request->search, function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('nip', 'like', '%' . $request->search . '%');
            })
            ->orderBy('nama')
            ->paginate(10);

        return view('pembimbing.index', compact('pembimbing'));
    }

    public function create()
    {
        $dudis = Dudi::orderBy('nama')->get();

        return view('pembimbing.create', compact('dudis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:pembimbing,nip',
            'id_jurusan' => 'nullable|exists:jurusan,id_jurusan',
            'pangkat' => 'nullable|string|max:255',
            'golongan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'jumlah_jam_mengajar' => 'nullable|integer|min:0',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',

            // DUDI
            'dudi_ids' => 'required|array',
            'dudi_ids.*' => 'exists:dudi,id_dudi',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('pembimbing', 'public');
        }

        $pembimbing = Pembimbing::create($data);

        // SIMPAN RELASI MANY TO MANY
        $pembimbing->dudis()->sync($request->dudi_ids);

        return redirect()
            ->route('pembimbing.index')
            ->with('success', 'Data pembimbing berhasil ditambahkan');
    }

    public function show(Pembimbing $pembimbing)
    {
        $pembimbing->load('dudis');

        return view('pembimbing.show', compact('pembimbing'));
    }

    public function edit(Pembimbing $pembimbing)
    {
        $dudis = Dudi::orderBy('nama')->get();
        $selectedDudi = $pembimbing->dudis->pluck('id_dudi')->toArray();

        return view('pembimbing.edit', compact('pembimbing', 'dudis', 'selectedDudi'));
    }

    public function update(Request $request, Pembimbing $pembimbing)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'nip' => 'required|string|max:255|unique:pembimbing,nip,' . $pembimbing->id_pembimbing . ',id_pembimbing',
            'id_jurusan' => 'nullable|exists:jurusan,id_jurusan',
            'pangkat' => 'nullable|string|max:255',
            'golongan' => 'nullable|string|max:255',
            'jabatan' => 'nullable|string|max:255',
            'jumlah_jam_mengajar' => 'nullable|integer|min:0',
            'no_hp' => 'nullable|string|max:20',
            'foto' => 'nullable|image|max:2048',

            // DUDI
            'dudi_ids' => 'required|array',
            'dudi_ids.*' => 'exists:dudi,id_dudi',
        ]);

        if ($request->hasFile('foto')) {
            if ($pembimbing->foto) {
                Storage::disk('public')->delete($pembimbing->foto);
            }
            $data['foto'] = $request->file('foto')->store('pembimbing', 'public');
        }

        $pembimbing->update($data);

        // UPDATE RELASI
        $pembimbing->dudis()->sync($request->dudi_ids);

        return redirect()
            ->route('pembimbing.index')
            ->with('success', 'Data pembimbing berhasil diperbarui');
    }

    public function destroy(Pembimbing $pembimbing)
    {
        if ($pembimbing->foto) {
            Storage::disk('public')->delete($pembimbing->foto);
        }

        // HAPUS RELASI PIVOT
        $pembimbing->dudis()->detach();

        $pembimbing->delete();

        return redirect()
            ->route('pembimbing.index')
            ->with('success', 'Data pembimbing berhasil dihapus');
    }
}
