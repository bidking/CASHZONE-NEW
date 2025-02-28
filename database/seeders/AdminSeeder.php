<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Menambahkan data Admin dengan id 123
        Admin::create([
            'id' => 123,
            'name' => 'Admin Example',
            'email' => 'admin@example.com',
            'password' => Hash::make('11111111'),  // Pastikan password di-hash
            'image' => null,  // Sesuaikan jika ingin menambahkan gambar
            'status' => 'admin',
        ]);

        // Menambahkan data admin lainnya (contoh data bebas)
    
    }
}
