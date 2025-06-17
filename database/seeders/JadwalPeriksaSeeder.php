<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalPeriksaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Seeder ini akan membuat 2-3 jadwal per dokter dengan ketentuan:
     * - Hanya 1 jadwal yang berstatus aktif per dokter
     * - Setiap jadwal berdurasi 3 jam
     * - Jadwal disesuaikan dengan spesialisasi dokter
     */
    public function run(): void
    {
        $dokters = User::where('role', 'dokter')->get();

        // Data jadwal yang lebih spesifik per dokter
        $jadwalData = [
            'Dr. Budi Santoso, Sp.PD' => [
                ['hari' => 'Senin', 'jam_mulai' => '08:00:00', 'status' => true],
                ['hari' => 'Rabu', 'jam_mulai' => '13:00:00', 'status' => false],
                ['hari' => 'Jumat', 'jam_mulai' => '10:00:00', 'status' => false],
            ],
            'Dr. Siti Rahayu, Sp.A' => [
                ['hari' => 'Selasa', 'jam_mulai' => '09:00:00', 'status' => true],
                ['hari' => 'Kamis', 'jam_mulai' => '14:00:00', 'status' => false],
                ['hari' => 'Sabtu', 'jam_mulai' => '08:00:00', 'status' => false],
            ],
            'Dr. Ahmad Wijaya, Sp.OG' => [
                ['hari' => 'Senin', 'jam_mulai' => '13:00:00', 'status' => false],
                ['hari' => 'Rabu', 'jam_mulai' => '08:00:00', 'status' => true],
                ['hari' => 'Jumat', 'jam_mulai' => '15:00:00', 'status' => false],
            ],
            'Dr. Rina Putri, Sp.M' => [
                ['hari' => 'Selasa', 'jam_mulai' => '10:00:00', 'status' => false],
                ['hari' => 'Kamis', 'jam_mulai' => '08:00:00', 'status' => true],
            ],
            'Dr. Doni Pratama, Sp.THT' => [
                ['hari' => 'Senin', 'jam_mulai' => '10:00:00', 'status' => false],
                ['hari' => 'Rabu', 'jam_mulai' => '15:00:00', 'status' => false],
                ['hari' => 'Jumat', 'jam_mulai' => '08:00:00', 'status' => true],
            ],
        ];

        foreach ($dokters as $dokter) {
            $namaJadwal = $jadwalData[$dokter->nama] ?? [];
            
            // Jika dokter tidak ada di data, buat jadwal default
            if (empty($namaJadwal)) {
                $jumlahJadwal = rand(2, 3);
                $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                $hariTerpakai = [];
                $indexAktif = rand(0, $jumlahJadwal - 1);

                for ($i = 0; $i < $jumlahJadwal; $i++) {
                    do {
                        $hari = $hariList[array_rand($hariList)];
                    } while (in_array($hari, $hariTerpakai));
                    
                    $hariTerpakai[] = $hari;
                    $jamMulaiOptions = ['08:00:00', '10:00:00', '13:00:00', '15:00:00'];
                    $jamMulai = $jamMulaiOptions[array_rand($jamMulaiOptions)];
                    
                    $namaJadwal[] = [
                        'hari' => $hari,
                        'jam_mulai' => $jamMulai,
                        'status' => ($i === $indexAktif),
                    ];
                }
            }

            // Buat jadwal berdasarkan data
            foreach ($namaJadwal as $jadwal) {
                $jamSelesai = date('H:i:s', strtotime($jadwal['jam_mulai'] . ' +3 hours'));
                
                $dokter->jadwalPeriksas()->create([
                    'hari' => $jadwal['hari'],
                    'jam_mulai' => $jadwal['jam_mulai'],
                    'jam_selesai' => $jamSelesai,
                    'status' => $jadwal['status'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
