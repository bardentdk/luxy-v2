<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;
        $isEdit = $userId !== null;

        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => [
                'required',
                'email',
                'max:255',
                'unique:users,email,' . ($userId ?? 'NULL'),
            ],
            'phone'      => ['nullable', 'string', 'max:20'],
            'role_id'    => ['nullable', 'integer', 'exists:roles,id'],
            'is_active'  => ['boolean'],
            'password'   => $isEdit
                ? ['nullable', 'string', Password::min(8)]
                : ['required', 'string', Password::min(8)],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Le prénom est obligatoire.',
            'last_name.required'  => 'Le nom est obligatoire.',
            'email.required'      => "L'adresse email est obligatoire.",
            'email.email'         => "L'adresse email n'est pas valide.",
            'email.unique'        => 'Cette adresse email est déjà utilisée.',
            'password.required'   => 'Le mot de passe est obligatoire.',
            'role_id.exists'      => 'Le rôle sélectionné est invalide.',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
        ]);
    }
}