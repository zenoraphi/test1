<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\Pembimbing;
use App\Models\Dudi;

class SiswaController extends Controller
{
    /**
     * ======================
     * INDEX
     * ======================
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Siswa::with(['jurusan', 'pembimbing', 'dudi']);

        // 🔒 Admin jurusan hanya lihat jurusannya
        if ($user->role === 'admin_jurusan') {
            $query->where('id_jurusan', $user->jurusan_id);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('jurusan') && $user->role === 'super_admin') {
            $query->where('id_jurusan', $request->jurusan);
        }

        $siswa = $query->latest()->paginate(10)->withQueryString();
        $total = $query->count();

        $jurusan = $user->role === 'super_admin'
            ? Jurusan::orderBy('jurusan')->get()
            : Jurusan::where('id_jurusan', $user->jurusan_id)->get();

        return view('siswa.index', compact('siswa', 'total', 'jurusan'));
    }

    /**
     * ======================
     * CREATE
     * ======================
     */
    public function create()
    {
        $user = Auth::user();

        $pembimbing = Pembimbing::orderBy('nama')->get();

        // 🔥 HANYA DUDI YANG MASIH ADA SLOT
        $dudi = Dudi::whereRaw(
            '(select count(*) from siswa where siswa.id_dudi = dudi.id_dudi) < daya_tampung'
        )
            ->orderBy('nama')
            ->get();

        $jurusan = $user->role === 'admin_jurusan'
            ? Jurusan::where('id_jurusan', $user->jurusan_id)->get()
            : Jurusan::orderBy('jurusan')->get();

        return view('siswa.create', compact('jurusan', 'pembimbing', 'dudi'));
    }

    /**
     * ======================
     * STORE
     * ======================
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'nama'           => 'required|string|max:255',
            'alamat'         => 'nullable|string',
            'jenis_kelamin'  => 'required|in:L,P',
            'id_jurusan'     => 'nullable|exists:jurusan,id_jurusan',
            'id_pembimbing'  => 'required|exists:pembimbing,id_pembimbing',
            'id_dudi'        => 'required|exists:dudi,id_dudi',
            'kelas'          => 'required|string|max:50',
            'kendaraan'      => 'nullable|string|max:50',
        ]);

        // 🔒 Paksa jurusan admin jurusan
        if ($user->role === 'admin_jurusan') {
            $data['id_jurusan'] = $user->jurusan_id;
        }

        // 🔥 CEK DAYA TAMPUNG DUDI (FINAL GUARD)
        $dudi = Dudi::findOrFail($data['id_dudi']);

        if ($dudi->siswas()->count() >= $dudi->daya_tampung) {
            return back()
                ->withErrors([
                    'id_dudi' => 'DUDI sudah penuh. Tambahkan daya tampung terlebih dahulu.'
                ])
                ->withInput();
        }

        Siswa::create($data);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan');
    }

    /**
     * ======================
     * SHOW
     * ======================
     */
    public function show(Siswa $siswa)
    {
        return view('siswa.show', compact('siswa'));
    }

    /**
     * ======================
     * EDIT
     * ======================
     */
    public function edit(Siswa $siswa)
    {
        $user = Auth::user();

        if ($user->role === 'admin_jurusan' && $siswa->id_jurusan !== $user->jurusan_id) {
            abort(403);
        }

        $jurusan = $user->role === 'admin_jurusan'
            ? Jurusan::where('id_jurusan', $user->jurusan_id)->get()
            : Jurusan::orderBy('jurusan')->get();

        $pembimbing = Pembimbing::orderBy('nama')->get();

        // 🔥 DUDI tersedia + DUDI lama (walaupun penuh)
        $dudi = Dudi::whereRaw(
            '(select count(*) from siswa where siswa.id_dudi = dudi.id_dudi) < daya_tampung
             OR id_dudi = ?',
            [$siswa->id_dudi]
        )
            ->orderBy('nama')
            ->get();

        return view('siswa.edit', compact('siswa', 'jurusan', 'pembimbing', 'dudi'));
    }

    /**
     * ======================
     * UPDATE
     * ======================
     */
    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nama'           => 'required|string|max:255',
            'alamat'         => 'nullable|string',
            'jenis_kelamin'  => 'required|in:L,P',
            'id_jurusan'     => 'required|exists:jurusan,id_jurusan',
            'id_pembimbing'  => 'required|exists:pembimbing,id_pembimbing',
            'id_dudi'        => 'required|exists:dudi,id_dudi',
            'kelas'          => 'required|string|max:50',
            'kendaraan'      => 'nullable|string|max:50',
        ]);

        // 🔥 Jika pindah DUDI → cek kapasitas
        if ($data['id_dudi'] != $siswa->id_dudi) {
            $dudiBaru = Dudi::findOrFail($data['id_dudi']);

            if ($dudiBaru->siswas()->count() >= $dudiBaru->daya_tampung) {
                return back()
                    ->withErrors([
                        'id_dudi' => 'DUDI tujuan sudah penuh.'
                    ])
                    ->withInput();
            }
        }

        $siswa->update($data);

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil diperbarui');
    }

    /**
     * ======================
     * DESTROY
     * ======================
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()
            ->route('siswa.index')
            ->with('success', 'Data siswa berhasil dihapus');
    }
}
