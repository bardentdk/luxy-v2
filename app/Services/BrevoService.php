<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoService
{
    private string $apiKey;
    private string $baseUrl = 'https://api.brevo.com/v3';

    public function __construct()
    {
        $this->apiKey = config('brevo.api_key', '');
    }

    /**
     * Headers communs à toutes les requêtes.
     */
    private function headers(): array
    {
        return [
            'api-key'      => $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept'       => 'application/json',
        ];
    }

    /**
     * Envoi via un template Brevo.
     */
    public function sendTemplate(
        string $toEmail,
        string $toName,
        int $templateId,
        array $params = []
    ): bool {
        if (empty($this->apiKey)) {
            Log::warning('Brevo API key non configurée — email non envoyé.');
            return false;
        }

        try {
            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/smtp/email", [
                    'sender' => [
                        'email' => config('brevo.sender_email'),
                        'name'  => config('brevo.sender_name'),
                    ],
                    'to' => [
                        ['email' => $toEmail, 'name' => $toName],
                    ],
                    'templateId' => $templateId,
                    'params'     => $params,
                ]);

            if ($response->failed()) {
                Log::error('Brevo sendTemplate failed', [
                    'status'   => $response->status(),
                    'body'     => $response->body(),
                    'template' => $templateId,
                    'to'       => $toEmail,
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Brevo sendTemplate exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Envoi d'un email simple sans template.
     */
    public function sendEmail(
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlContent,
        ?string $textContent = null
    ): bool {
        if (empty($this->apiKey)) {
            Log::warning('Brevo API key non configurée — email non envoyé.');
            return false;
        }

        try {
            $payload = [
                'sender' => [
                    'email' => config('brevo.sender_email'),
                    'name'  => config('brevo.sender_name'),
                ],
                'to'          => [['email' => $toEmail, 'name' => $toName]],
                'subject'     => $subject,
                'htmlContent' => $htmlContent,
            ];

            if ($textContent) {
                $payload['textContent'] = $textContent;
            }

            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/smtp/email", $payload);

            if ($response->failed()) {
                Log::error('Brevo sendEmail failed', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                    'to'     => $toEmail,
                ]);
                return false;
            }

            return true;
        } catch (\Exception $e) {
            Log::error('Brevo sendEmail exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Notification admin nouveau contact.
     */
    public function notifyAdminNewContact(array $contactData): bool
    {
        $templateId = config('brevo.templates.contact_admin');

        if ($templateId) {
            return $this->sendTemplate(
                config('brevo.admin_email'),
                config('brevo.sender_name'),
                (int) $templateId,
                $contactData
            );
        }

        $html = "
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom :</strong> {$contactData['FIRSTNAME']}</p>
            <p><strong>Email :</strong> {$contactData['EMAIL']}</p>
            <p><strong>Téléphone :</strong> {$contactData['PHONE']}</p>
            <p><strong>Objet :</strong> {$contactData['SUBJECT']}</p>
            <hr>
            <p>{$contactData['MESSAGE']}</p>
        ";

        return $this->sendEmail(
            config('brevo.admin_email'),
            config('brevo.sender_name'),
            '📩 Nouveau message de contact — ' . $contactData['SUBJECT'],
            $html
        );
    }

    /**
     * Confirmation automatique à l'expéditeur.
     */
    public function sendContactConfirmation(string $email, string $name): bool
    {
        $templateId = config('brevo.templates.contact_confirmation');

        if ($templateId) {
            return $this->sendTemplate(
                $email,
                $name,
                (int) $templateId,
                ['FIRSTNAME' => $name]
            );
        }

        $senderName = config('brevo.sender_name');
        $html = "
            <p>Bonjour <strong>{$name}</strong>,</p>
            <p>Nous avons bien reçu votre message et vous répondrons dans les plus brefs délais.</p>
            <p>En attendant, n'hésitez pas à consulter notre catalogue de formations sur notre site.</p>
            <br>
            <p>Cordialement,</p>
            <p><strong>L'équipe {$senderName}</strong></p>
        ";

        return $this->sendEmail(
            $email,
            $name,
            'Nous avons bien reçu votre message — ' . $senderName,
            $html
        );
    }
}