<?php
namespace App\Imports;

use App\Models\Tabungan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TabunganImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Tabungan([
            'name'        => $row['name'] ?? null,
            'status'      => $row['status'] ?? null,
            'kelas'       => $row['kelas'] ?? null,
            'walas'       => $row['walas'] ?? null,
            // Ubah pemetaan dari 'acara' menjadi 'nama_acara'
            'nama_acara'  => $row['acara'] ?? null,
            'tanggal_acara'  => $row['tanggal_acara'] ?? null,
            'jumlah_bayar'  => $row['jumlah_bayar'] ?? null,
        ]);
    }
}

