<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'status' => 'required|string|in:admin,guru,siswa',
        ];

        // Ambil ID pengguna yang sedang di-edit
        $userId = $this->route('id');

        // Validasi berdasarkan status
        switch ($this->status) {
            case 'admin':
                $rules += [
                    'id' => [
                        'required',
                        'integer',
                        Rule::unique('admins', 'id')->ignore($userId), // Abaikan ID yang sedang di-edit
                    ],
                    'name' => 'required|string|max:255',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('admins', 'email')->ignore($userId), // Abaikan email yang sedang di-edit
                    ],
                    'password' => 'nullable|string|min:8',
                    'image' => 'nullable|image',
                    'status' => 'nullable|string|max:25',
                ];
                break;

            case 'guru':
                $rules += [
                    'id' => [
                        'required',
                        'integer',
                        Rule::unique('gurus', 'id')->ignore($userId), // Abaikan ID yang sedang di-edit
                    ],
                    'name' => 'required|string|max:255',
                    'email' => [
                        'required',
                        'email',
                        Rule::unique('gurus', 'email')->ignore($userId), // Abaikan email yang sedang di-edit
                    ],
                    'password' => 'nullable|string|min:8',
                    'image' => 'nullable|image',
                    'status' => 'nullable|string|max:25',
                    'kelas' => 'required|string|max:25',
                ];
                break;

            case 'siswa':
                $rules += [
                    'id' => [
                        'required',
                        'integer',
                        Rule::unique('siswas', 'id')->ignore($userId), // Abaikan ID yang sedang di-edit
                    ],
                    'name' => 'required|string|max:255',
                    'password' => 'nullable|string|min:8',
                    'status' => 'nullable|string|max:25',
                    'kelas' => 'required|string|max:25',
                    'walas' => 'required|string|max:25',
                    'image' => 'nullable|image',
                    'gander' => 'required|in:male,female',
                ];
                break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'id.unique' => 'ID sudah digunakan. Silakan gunakan ID lain.',
            'email.unique' => 'Email sudah digunakan. Silakan gunakan email lain.',
        ];
    }
}