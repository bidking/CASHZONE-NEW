<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acara extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_acara',
        'tanggal_acara',
        'jumlah_bayar',
    ];
    public function getJumlahBayarFormattedAttribute()
    {
        return number_format($this->jumlah_bayar, 0, ',', '.');
    }
}