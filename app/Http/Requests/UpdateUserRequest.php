<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isSuperAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user');

        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password'      => ['nullable', 'string', 'min:8'],
            'role_id'       => ['required', 'exists:roles,id'],
            'direktorat_id' => ['nullable', 'exists:direktorats,id'],
        ];
    }
}