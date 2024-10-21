<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Data;

class KaryawanImport implements ToModel
{
    public function model(array $row)
    {
        // Pastikan untuk menyesuaikan indeks array dengan kolom di Excel Anda
        return new Data([
            'nomer_polisi' => $row[0], // Ganti dengan indeks kolom yang benar
            'volume' => $row[1], // Ganti dengan indeks kolom yang benar
            'sopir' => $row[2], // Jika ingin memasukkan nama sopir
        ]);
    }
}
