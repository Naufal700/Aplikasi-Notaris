<?php

namespace App\Imports;

use App\Models\Master\Klien;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KlienImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Klien([
            'nama'       => $row['nama'],
            'alamat'     => $row['alamat'] ?? null,
            'email'      => $row['email'] ?? null,
            'telepon'    => $row['telepon'] ?? null,
            'npwp'       => $row['npwp'] ?? null,
            'jenis_klien' => $row['jenis_klien'] ?? null,
            'keterangan' => $row['keterangan'] ?? null,
        ]);
    }
}
