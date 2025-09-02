<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class KlienTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Nama', 'Alamat', 'Email', 'Telepon', 'NPWP', 'Jenis Klien', 'Keterangan']
        ];
    }

    public function headings(): array
    {
        return ['Nama', 'Alamat', 'Email', 'Telepon', 'NPWP', 'Jenis Klien', 'Keterangan'];
    }
}
