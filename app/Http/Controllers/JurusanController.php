<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JurusanController extends Controller
{
    /**
     * INDEX JURUSAN
     * - HANYA SUPER ADMIN
     */
    public function index()
    {
        return view('jurusan.index', [
            'jurusans' => Jurusan::orderBy('jurusan')->get()
        ]);
    }

    /**
     * SHOW JURUSAN
     * - super admin : bebas
     * - admin jurusan : hanya jurusannya sendiri
     */
    public function show(Jurusan $jurusan)
    {
        $user = Auth::user();

        if (
            $user->role === 'admin_jurusan' &&
            $user->jurusan_id !== $jurusan->id_jurusan
        ) {
            abort(403);
        }

        return view('jurusan.show', compact('jurusan'));
    }

    /**
     * EDIT JURUSAN
     * - super admin : bebas
     * - admin jurusan : hanya jurusannya sendiri
     */
    public function edit(Jurusan $jurusan)
    {
        $user = Auth::user();

        if (
            $user->role === 'admin_jurusan' &&
            $user->jurusan_id !== $jurusan->id_jurusan
        ) {
            abort(403);
        }

        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * UPDATE JURUSAN
     * - super admin : bebas
     * - admin jurusan : hanya jurusannya sendiri
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $user = Auth::user();

        if (
            $user->role === 'admin_jurusan' &&
            $user->jurusan_id !== $jurusan->id_jurusan
        ) {
            abort(403);
        }

        $validated = $request->validate([
            'jurusan' => 'required|string|max:100',
        ]);

        $jurusan->update($validated);

        return redirect()
            ->route('jurusan.show', $jurusan->id_jurusan)
            ->with('success', 'Data jurusan berhasil diperbarui');
    }
}
