<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;
class Admin extends Model
{
    use HasFactory;

    protected $fillable = ['id','name', 'email', 'password', 'image', 'status'];
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
public function getFormattedDob(){
    return  date('d M Y' ,strtotime($this->dob));
}
}