<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nisn',
        'name',
        // 'password',
        'status',
        'kelas',
        'walas',
        'image',
        'gander',

        'nama_acara',
        'tanggal_acara',
        'jumlah_bayar',

        'no_telpon',
        'tagihan',
        'total_masuk',
        'tipe_pembayaran',
    ];

    // Di model Tabungan
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'name', 'name');
    }
public function acara()
{
    return $this->belongsTo(Acara::class, 'nama_acara', 'nama_acara');
}
public function getWhatsappNumberAttribute()
{
    $phone = preg_replace('/\D/', '', $this->no_telpon);
    if (substr($phone, 0, 1) === '0') {
        $phone = '62' . substr($phone, 1);
    }
    return $phone;
}
public function getImageURL()
{
    if ($this->image) {
        $imagePath = 'public/' . $this->image;

        if (Storage::exists($imagePath)) {
            return url('storage/' . $this->image);
        }
    }
    
    return url('storage/default-user.png');
}

}
    