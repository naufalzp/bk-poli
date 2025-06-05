<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class JadwalPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dokters = User::where('role', 'dokter')->get();

        foreach ($dokters as $dokter) {
            $jumlahJadwal = rand(1, 5);
            $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $jadwalPeriksa = [];

            for ($i = 0; $i < $jumlahJadwal; $i++) {
                $hari = Arr::random($hariList);
                $jamMulai = sprintf('%02d:00:00', rand(7, 15));
                $jamSelesai = date('H:i:s', strtotime($jamMulai . ' +'.rand(1,4).' hours'));
                $status = (bool)rand(0, 1);

                $jadwalPeriksa[] = [
                    'id_dokter' => $dokter->id,
                    'hari' => $hari,
                    'jam_mulai' => $jamMulai,
                    'jam_selesai' => $jamSelesai,
                    'status' => $status,
                ];
            }

            $dokter->jadwalPeriksas()->createMany($jadwalPeriksa);
        }
    }
}
