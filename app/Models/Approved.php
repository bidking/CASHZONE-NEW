<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approved extends Model
{
    use HasFactory;

    protected $table = 'approved';

    protected $fillable = [
        'nisn',
        'name',
        'status',
        'kelas',
        'walas',
        'image', // digunakan untuk menyimpan foto/bukti pembayaran
        'gander',
        'nama_acara',
        'tanggal_acara',
        'jumlah_bayar',
        'no_telpon',
        'tagihan',
        'total_masuk',
        'tipe_pembayaran'
    ];
}
