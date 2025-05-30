<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ObatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obats = [
            [
                'nama_obat' => 'Paracetamol',
                'kemasan' => 'Tablet',
                'harga' => 5000,
            ],
            [
                'nama_obat' => 'Amoxicillin',
                'kemasan' => 'Kapsul',
                'harga' => 10000,
            ],
            [
                'nama_obat' => 'Ibuprofen',
                'kemasan' => 'Tablet',
                'harga' => 7500,
            ],
            [
                'nama_obat' => 'Cetirizine',
                'kemasan' => 'Sirup',
                'harga' => 12000,
            ],
            [
                'nama_obat' => 'Omeprazole',
                'kemasan' => 'Tablet',
                'harga' => 15000,
            ],
            [
                'nama_obat' => 'Metformin',
                'kemasan' => 'Tablet',
                'harga' => 20000,
            ],
            [
                'nama_obat' => 'Simvastatin',
                'kemasan' => 'Tablet',
                'harga' => 18000,
            ],
            [
                'nama_obat' => 'Amlodipine',
                'kemasan' => 'Tablet',
                'harga' => 22000,
            ],
            [
                'nama_obat' => 'Losartan',
                'kemasan' => 'Tablet',
                'harga' => 25000,
            ],
            [
                'nama_obat' => 'Levothyroxine',
                'kemasan' => 'Tablet',
                'harga' => 30000,
            ],
        ];

        foreach ($obats as $obat) {
            \App\Models\Obat::create($obat);
        }
    }
}
