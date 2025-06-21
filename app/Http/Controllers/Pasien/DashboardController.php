<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\JanjiPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $no_rm = Auth::user()->no_rm;

        $janjiPeriksas = JanjiPeriksa::where('id_pasien', Auth::user()->id)
            ->with(['jadwalPeriksa.dokter.poli', 'periksa'])
            ->orderBy('created_at', 'desc')
            ->whereDoesntHave('periksa')
            ->paginate(10);

        return view('pasien.dashboard')->with([
            'no_rm' => $no_rm,
            'janjiPeriksas' => $janjiPeriksas,
        ]);
    }
}
