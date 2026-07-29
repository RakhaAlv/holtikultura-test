<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Hanya izinkan jika pengguna adalah Super Admin
        return $this->user() && $this->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'string', 'min:8'],
            'role_id'       => ['required', 'exists:roles,id'],
            'direktorat_id' => ['nullable', 'exists:direktorats,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique'        => 'Alamat email sudah terdaftar pada sistem.',
            'role_id.exists'      => 'Role yang dipilih tidak valid.',
            'direktorat_id.exists'=> 'Direktorat yang dipilih tidak valid.',
        ];
    }
}