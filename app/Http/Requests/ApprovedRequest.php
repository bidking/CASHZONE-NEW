<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovedRequest extends FormRequest
{
    public function authorize()
    {
        // Ubah sesuai kebutuhan otorisasi kamu
        return true;
    }

    public function rules()
    {
        $rules = [
            'nisn'          => 'required|string|max:255',
            'name'          => 'required|string|max:255',
            'status'        => 'nullable|string|max:50',
            'kelas'         => 'nullable|string|max:50',
            'walas'         => 'nullable|string|max:255',
            'image' => 'nullable|image',
            'gander'        => 'nullable|string|max:50',
            // Field dari tabel acara
            'nama_acara'    => 'nullable|string|max:255',
            'tanggal_acara' => 'nullable|date',
            'jumlah_bayar'  => 'required|numeric',
            // Field tambahan
            'total_masuk'   => 'nullable|numeric',
            'tagihan'       => 'nullable|numeric',
            'no_telpon'     => 'nullable|string|max:20',
            'tipe_pembayaran'     => 'nullable|string|max:52',
            // Field tambahan lain bisa ditambahkan sesuai kebutuhan (misal nisn, name, dll)
        ];

       

        return $rules;
    }
}
