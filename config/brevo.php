<?php

return [
    'api_key'       => env('BREVO_API_KEY', ''),
    'sender_email'  => env('BREVO_SENDER_EMAIL', 'contact@luxyformation.re'),
    'sender_name'   => env('BREVO_SENDER_NAME', 'Luxy Coaching & Formation'),
    'reply_to'      => env('BREVO_REPLY_TO', 'contact@luxyformation.re'),

    'templates' => [
        'contact_confirmation' => env('BREVO_TPL_CONTACT_CONFIRM', 1),
        'contact_admin'        => env('BREVO_TPL_CONTACT_ADMIN', 2),
        'welcome'              => env('BREVO_TPL_WELCOME', 3),
        'formation_interest'   => env('BREVO_TPL_FORMATION', 4),
    ],

    'admin_email' => env('BREVO_ADMIN_EMAIL', 'admin@luxyformation.re'),
];