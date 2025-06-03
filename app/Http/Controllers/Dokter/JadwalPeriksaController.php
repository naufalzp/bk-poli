<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalPeriksaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwalPeriksas = JadwalPeriksa::where('id_dokter', Auth::id())
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->paginate(10);

        return view('dokter.jadwal-periksa.index', compact('jadwalPeriksas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dokter.jadwal-periksa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $validated['hari'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
            'status' => false,
        ]);

        return redirect()->route('dokter.jadwal-periksa.index')
            ->with('status', 'jadwal-periksa-created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);

        if ($jadwalPeriksa->id_dokter != Auth::user()->id)
            return redirect()->route('dokter.jadwal-periksa.index');

        return view('dokter.jadwal-periksa.edit', compact('jadwalPeriksa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'hari' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);

        if ($jadwalPeriksa->id_dokter != Auth::user()->id)
            return redirect()->route('dokter.jadwal-periksa.index');

        $jadwalPeriksa->update($validated);

        return redirect()->route('dokter.jadwal-periksa.index')
            ->with('status', 'jadwal-periksa-updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);

        if ($jadwalPeriksa->id_dokter != Auth::user()->id)
            return redirect()->route('dokter.jadwal-periksa.index');

        $jadwalPeriksa->delete();

        return redirect()->route('dokter.jadwal-periksa.index');
    }

    /**
     * Update status the specified resource from storage.
     */
    public function updateStatus(string $id)
    {
        $jadwalPeriksa = JadwalPeriksa::findOrFail($id);

        if ($jadwalPeriksa->id_dokter != Auth::user()->id)
            return redirect()->route('dokter.jadwal-periksa.index');

        if (!$jadwalPeriksa->status) {
            JadwalPeriksa::where('id_dokter', Auth::user()->id)
                ->update(['status' => 0]);

            $jadwalPeriksa->status = true;
            $jadwalPeriksa->save();

            return redirect()->route('dokter.jadwal-periksa.index');
        }

        $jadwalPeriksa->status = false;
        $jadwalPeriksa->save();

        return redirect()->route('dokter.jadwal-periksa.index');
    }
}
