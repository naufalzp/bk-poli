<?php

namespace Database\Seeders;

use App\Models\Poli;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $polis = [
            [
                'nama' => 'Gigi',
                'deskripsi' => 'Ini adalah poli Gigi'
            ],
            [
                'nama' => 'Anak',
                'deskripsi' => 'Ini adalah poli Anak'
            ],
            [
                'nama' => 'Penyakit Dalam',
                'deskripsi' => 'Ini adalah poli Penyakit Dalam'
            ],
        ];

        foreach($polis as $poli) {
            Poli::create($poli);
        }
    }
}
