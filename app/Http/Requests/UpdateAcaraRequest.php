<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAcaraRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_acara' => 'required|string|max:255',
            'tanggal_acara' => 'required|date',
            'jumlah_bayar' => 'required|numeric',
        ];
    }
}