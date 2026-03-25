<?php

namespace App\Services;

use App\Models\ContactForm;
use Illuminate\Support\Facades\Log;

class ContactService
{
    public function __construct(private readonly BrevoService $brevo)
    {}

    /**
     * Enregistrer un message de contact et envoyer les emails.
     */
    public function store(array $data): ContactForm
    {
        $contact = ContactForm::create([
            'full_name'          => $data['full_name'],
            'email'              => $data['email'],
            'phone'              => $data['phone'] ?? null,
            'subject'            => $data['subject'],
            'message'            => $data['message'],
            'formation_interest' => $data['formation_interest'] ?? null,
            'ip_address'         => request()->ip(),
            'user_agent'         => request()->userAgent(),
        ]);

        // Email de confirmation à l'utilisateur
        $this->brevo->sendContactConfirmation($contact->email, $contact->full_name);

        // Notification à l'admin
        $this->brevo->notifyAdminNewContact([
            'FIRSTNAME' => $contact->full_name,
            'EMAIL'     => $contact->email,
            'PHONE'     => $contact->phone ?? 'Non renseigné',
            'SUBJECT'   => $contact->subject,
            'MESSAGE'   => $contact->message,
        ]);

        Log::info('New contact form submitted', ['id' => $contact->id, 'email' => $contact->email]);

        return $contact;
    }
}