<?php

namespace App\Http\Requests\Public;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name'          => ['required', 'string', 'max:100'],
            'email'              => ['required', 'email', 'max:255'],
            'phone'              => ['nullable', 'string', 'max:20'],
            'subject'            => ['required', 'string', 'max:150'],
            'message'            => ['required', 'string', 'min:20', 'max:2000'],
            'formation_interest' => ['nullable', 'string', 'max:150'],
            'accept_rgpd'        => ['required', 'accepted'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required'   => 'Votre nom complet est obligatoire.',
            'email.required'       => 'L\'adresse email est obligatoire.',
            'email.email'          => 'L\'adresse email n\'est pas valide.',
            'subject.required'     => 'L\'objet du message est obligatoire.',
            'message.required'     => 'Le message est obligatoire.',
            'message.min'          => 'Le message doit contenir au moins 20 caractères.',
            'accept_rgpd.required' => 'Vous devez accepter notre politique de confidentialité.',
            'accept_rgpd.accepted' => 'Vous devez accepter notre politique de confidentialité.',
        ];
    }
}