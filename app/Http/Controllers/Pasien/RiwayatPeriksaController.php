<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPeriksaController extends Controller   
{
    public function index(Request $request)
    {
        $no_rm = Auth::user()->no_rm;

        $janjiPeriksas = JanjiPeriksa::where('id_pasien', Auth::user()->id)
            ->with(['jadwalPeriksa.dokter.poli', 'periksa'])
            ->orderBy('created_at', 'desc')
            ->whereHas('periksa')
            ->paginate(10);

        return view('pasien.riwayat-periksa.index')->with([
            'no_rm' => $no_rm,
            'janjiPeriksas' => $janjiPeriksas,
        ]);
    }

    public function detail($id)
    {
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa.dokter'])->findOrFail($id);

        return view('pasien.riwayat-periksa.detail')->with([
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }

    public function riwayat($id)
    {
        $janjiPeriksa = JanjiPeriksa::with(['jadwalPeriksa.dokter'])->findOrFail($id);
        $riwayat = $janjiPeriksa->riwayatPeriksa;

        return view('pasien.riwayat-periksa.riwayat')->with([
            'riwayat' => $riwayat,
            'janjiPeriksa' => $janjiPeriksa,
        ]);
    }
}
