<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $users;
    protected $acara; // Objek Acara yang dipilih

    /**
     * Inisialisasi dengan data pengguna yang akan diekspor.
     *
     * @param \Illuminate\Support\Collection $users
     * @param \App\Models\Acara|null $acara
     */
    public function __construct($users, $acara = null)
    {
        $this->users = $users;
        $this->acara = $acara;
    }

    /**
     * Mengembalikan koleksi data untuk diekspor.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->users;
    }

    /**
     * Mengatur header kolom pada file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'nisn',
            'name',
            'status',
            'kelas',
            'walas',
            'acara',
            'tanggal_acara',
            'jumlah_bayar',
        ];
    }

    /**
     * Mapping setiap baris data agar sesuai dengan urutan header.
     *
     * @param mixed $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,       // diasumsikan 'id' sebagai nisn
            $user->name,     // nama
            $user->status,   // status
            $user->kelas,    // kelas
            $user->walas,    // walas
            // Jika objek Acara tersedia, gunakan properti-nya; jika tidak, coba ambil dari relasi (jika ada)
            $this->acara ? $this->acara->nama_acara : ($user->acara->nama_acara ?? 'N/A'),
            $this->acara ? $this->acara->tanggal_acara : ($user->acara->tanggal_acara ?? 'N/A'),
            $this->acara ? $this->acara->jumlah_bayar : ($user->acara->jumlah_bayar ?? 'N/A'),
        ];
    }
}
