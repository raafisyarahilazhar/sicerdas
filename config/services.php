<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'fonnte' => [
        'token'   => env('FONNTE_TOKEN'),
        'country_code' => env('FONNTE_COUNTRY_CODE', '62'),
        'connect_only' => env('FONNTE_CONNECT_ONLY', true),
        'send_mode' => env('FONNTE_SEND_MODE', 'auto'),
    ],
    // 'whatsapp' => [
    //     'token'    => env('WHATSAPP_TOKEN'),
    //     'phone_id' => env('WHATSAPP_PHONE_ID'),
    //     'send_mode' => env('WHATSAPP_SEND_MODE', 'attachment'),
    // ]

];
