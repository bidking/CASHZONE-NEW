<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TabunganRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * Bersihkan nilai sebelum validasi, misalnya hapus separator ribuan
     */
    protected function prepareForValidation()
    {
        if ($this->has('jumlah_bayar')) {
            $this->merge([
                'jumlah_bayar' => str_replace('.', '', $this->jumlah_bayar)
            ]);
        }

        if ($this->has('total_masuk')) {
            $this->merge([
                'total_masuk' => str_replace('.', '', $this->total_masuk)
            ]);
        }
        
        // Jika Anda mengirimkan tagihan (meskipun biasanya dihitung), Anda bisa membersihkannya juga:
        if ($this->has('tagihan')) {
            $this->merge([
                'tagihan' => str_replace('.', '', $this->tagihan)
            ]);
        }
    }

    public function rules()
    {
        return [
            // Field dari tabel siswa
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
        ];
    }
}
