<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $rules = [
            'status' => 'required|string|in:admin,guru,siswa',
        ];
    
        // Validasi berdasarkan status
        switch ($this->status) {
            case 'admin':
                 $rules += [
                'id' => 'required|integer',
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:admins,email,' . $this->id,
                'password' => 'required|string|min:8',
                'image' => 'nullable|image',
                'status' => 'nullable|string|max:25',

            ];
            break;
            case 'guru':
                $rules += [
                    'id' => 'required|integer',
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:admins,email,' . $this->id,
                    'password' => 'required|string|min:8',
                    'image' => 'nullable|image',
                    'status' => 'nullable|string|max:25',
                    'kelas' => 'required|string|max:25',


                ];
                break;
    
            case 'siswa':
                $rules += [
                    'id' => 'required|integer',
                    'name' => 'required|string|max:255',
                    'password' => 'required|string|min:8',
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
    
    
}
