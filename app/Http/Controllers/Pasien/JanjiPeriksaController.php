<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JanjiPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $no_rm = Auth::user()->no_rm;
        $dokters = User::with([
            'jadwalPeriksas' => function ($query) {
                $query->where('status', true);
            },
        ])
            ->where('role', 'dokter')
            ->get();

        return view('pasien.janji-periksa.index', compact(['no_rm', 'dokters']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_jadwal_periksa' => 'required|exists:jadwal_periksas,id',
            'keluhan' => 'required|string'
        ]);

        $janjiPeriksaCount = JanjiPeriksa::where('id_jadwal_periksa', $validated['id_jadwal_periksa'])->count();
        $noAntrian = $janjiPeriksaCount + 1;

        JanjiPeriksa::create([
            'id_pasien' => Auth::user()->id,
            'id_jadwal_periksa' => $validated['id_jadwal_periksa'],
            'keluhan' => $validated['keluhan'],
            'no_antrian' => $noAntrian
        ]);

        return redirect()->route('pasien.janji-periksa.index')->with('status', 'janji-periksa-created');
    }
}
