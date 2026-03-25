<?php

namespace App\Services;

use Brevo\Client\Configuration;
use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Model\SendSmtpEmail;
use Brevo\Client\Model\SendSmtpEmailSender;
use Brevo\Client\Model\SendSmtpEmailTo;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class BrevoService
{
    private TransactionalEmailsApi $api;

    public function __construct()
    {
        $config = Configuration::getDefaultConfiguration()
            ->setApiKey('api-key', config('brevo.api_key'));

        $this->api = new TransactionalEmailsApi(new Client(), $config);
    }

    /**
     * Envoi d'un email via un template Brevo.
     */
    public function sendTemplate(
        string $toEmail,
        string $toName,
        int $templateId,
        array $params = []
    ): bool {
        try {
            $sendSmtpEmail = new SendSmtpEmail([
                'sender' => new SendSmtpEmailSender([
                    'email' => config('brevo.sender_email'),
                    'name'  => config('brevo.sender_name'),
                ]),
                'to' => [
                    new SendSmtpEmailTo([
                        'email' => $toEmail,
                        'name'  => $toName,
                    ]),
                ],
                'templateId' => $templateId,
                'params'     => $params,
            ]);

            $this->api->sendTransacEmail($sendSmtpEmail);
            return true;
        } catch (\Exception $e) {
            Log::error('Brevo sendTemplate error: ' . $e->getMessage(), [
                'template' => $templateId,
                'to'       => $toEmail,
            ]);
            return false;
        }
    }

    /**
     * Envoi d'un email simple (sans template).
     */
    public function sendEmail(
        string $toEmail,
        string $toName,
        string $subject,
        string $htmlContent,
        ?string $textContent = null
    ): bool {
        try {
            $sendSmtpEmail = new SendSmtpEmail([
                'sender' => new SendSmtpEmailSender([
                    'email' => config('brevo.sender_email'),
                    'name'  => config('brevo.sender_name'),
                ]),
                'to' => [
                    new SendSmtpEmailTo([
                        'email' => $toEmail,
                        'name'  => $toName,
                    ]),
                ],
                'subject'     => $subject,
                'htmlContent' => $htmlContent,
                'textContent' => $textContent,
            ]);

            $this->api->sendTransacEmail($sendSmtpEmail);
            return true;
        } catch (\Exception $e) {
            Log::error('Brevo sendEmail error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Notification de nouveau contact à l'admin.
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

        // Fallback sans template
        $html = view('emails.contact-admin', $contactData)->render();
        return $this->sendEmail(
            config('brevo.admin_email'),
            config('brevo.sender_name'),
            '📩 Nouveau message de contact — ' . $contactData['subject'],
            $html
        );
    }

    /**
     * Confirmation automatique à l'expéditeur du formulaire de contact.
     */
    public function sendContactConfirmation(string $email, string $name): bool
    {
        $templateId = config('brevo.templates.contact_confirmation');

        if ($templateId) {
            return $this->sendTemplate($email, $name, (int) $templateId, ['FIRSTNAME' => $name]);
        }

        $html = "<p>Bonjour {$name},</p><p>Nous avons bien reçu votre message et vous répondrons dans les plus brefs délais.</p><p>L'équipe Luxy Coaching & Formation</p>";
        return $this->sendEmail(
            $email,
            $name,
            'Nous avons bien reçu votre message — Luxy Coaching & Formation',
            $html
        );
    }
}