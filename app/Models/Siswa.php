<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [ 'id','name', 'password', 'status', 'kelas', 'walas', 'image', 'gander'];

    // app/Models/Guru.php

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
    public function guru()
    {
        return $this->belongsTo(Guru::class, 'walas', 'name'); // relasi ke model Guru
    }
public function getFormattedDob(){
    return  date('d M Y' ,strtotime($this->dob));
}
public function acara()
{
    return $this->belongsTo(Acara::class, 'acara_id', 'id');
}
public function lastTabungan()
{
    return $this->hasOne(Tabungan::class, 'name', 'name')->latestOfMany();
}
public function tabungans()
{
    return $this->hasMany(Tabungan::class);
}
}
