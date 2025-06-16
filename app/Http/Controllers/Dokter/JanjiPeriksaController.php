<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\JanjiPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JanjiPeriksaController extends Controller
{
    public function index()
    {
        $jadwalPeriksa = JadwalPeriksa::where('id_dokter', Auth::user()->id)
            ->where('status', true)->first();
        
        // Jika dokter belum memiliki jadwal periksa
        if (!$jadwalPeriksa) {
            return view('dokter.janji-periksa.index', [
                'jadwalPeriksa' => null,
                'janjiPeriksas' => collect() 
            ]);
        }
        
        $janjiPeriksas = JanjiPeriksa::where('id_jadwal_periksa', $jadwalPeriksa->id)
            ->whereDoesntHave('periksa')
            ->with('pasien')
            ->paginate(10);

        return view('dokter.janji-periksa.index', compact(['jadwalPeriksa', 'janjiPeriksas']));
    }

    public function show(string $id)
    {
        $janjiPeriksa = JanjiPeriksa::findOrFail($id);
        $jadwalPeriksa = JadwalPeriksa::findOrFail($janjiPeriksa->id_jadwal_periksa);
        $obats = Obat::all();

        if ($jadwalPeriksa->id_dokter !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('dokter.janji-periksa.show', compact(['janjiPeriksa', 'jadwalPeriksa', 'obats']));
    }

    public function store(Request $request, string $id)
    {
        
        $janjiPeriksa = JanjiPeriksa::with('pasien')->findOrFail($id);
        $jadwalPeriksa = JadwalPeriksa::findOrFail($janjiPeriksa->id_jadwal_periksa);
        
        if ($jadwalPeriksa->id_dokter !== Auth::user()->id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'obat' => 'required|array',
            'obat.*' => 'exists:obats,id',
            'tgl_periksa' => 'required|date',
            'catatan' => 'nullable|string|max:255',
            'biaya_periksa' => 'required|numeric',
        ]);

        $periksa = Periksa::create([
            'id_janji_periksa' => $janjiPeriksa->id,
            'tgl_periksa' => $validated['tgl_periksa'],
            'catatan' => $validated['catatan'],
            'biaya_periksa' => $validated['biaya_periksa'],
        ]);

        $periksa->obat()->attach($validated['obat']);

        return redirect()->route('dokter.janji-periksa.index')
            ->with('success', 'Pemeriksaan berhasil disimpan. Pasien ' . $janjiPeriksa->pasien->nama . ' telah diperiksa.');
    }
}
