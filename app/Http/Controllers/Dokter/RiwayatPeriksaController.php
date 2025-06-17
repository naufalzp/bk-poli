<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPeriksaController extends Controller
{
    public function index()
    {
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::user()->id)
            ->where('status', true)
            ->first();

        // Jika dokter belum memiliki jadwal periksa
        if (!$jadwalPeriksa) {
            return view('dokter.riwayat-periksa.index', [
                'jadwalPeriksa' => null,
                'periksas' => collect(),
            ]);
        }

        $periksas = Periksa::with(['janjiPeriksa.pasien'])
            ->whereHas('janjiPeriksa', function ($query) use ($jadwalPeriksa) {
                $query->where('id_jadwal_periksa', $jadwalPeriksa->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dokter.riwayat-periksa.index', compact([
            'jadwalPeriksa', 
            'periksas', 
        ]));
    }

    public function edit(string $id)
    {
        $periksa = Periksa::with(['janjiPeriksa.pasien', 'obats'])->findOrFail($id);

        if ($periksa->janjiPeriksa->jadwalPeriksa->id_dokter !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $obats = Obat::all();

        return view('dokter.riwayat-periksa.edit', compact(['periksa', 'obats']));
    }
    
    public function update(Request $request, string $id)
    {
        $periksa = Periksa::with(['janjiPeriksa.pasien', 'obats'])->findOrFail($id);

        if ($periksa->janjiPeriksa->jadwalPeriksa->id_dokter !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'obat' => 'required|array',
            'obat.*' => 'exists:obats,id',
            'tgl_periksa' => 'required|date',
            'catatan' => 'required|string|max:255',
            'biaya_periksa' => 'required|numeric',
        ]);

        $periksa->update([
            'tgl_periksa' => $validated['tgl_periksa'],
            'catatan' => $validated['catatan'],
            'biaya_periksa' => $validated['biaya_periksa'],
        ]);

        // Update relasi obat
        $periksa->obats()->sync($validated['obat']);

        return redirect()->route('dokter.riwayat-periksa.index')
            ->with('success', 'Riwayat periksa berhasil diperbarui.');
    }
}
