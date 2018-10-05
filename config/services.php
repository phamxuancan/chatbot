<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'botman' => [
        'facebook_token' => 'EAALx206BKSUBACIOq7OK7uqlGuMhoW7umn3lRqkDZAjowLEaBgVmlJQUgcw3NZBqxTIFyPZB9wKWl1gODa8U8JWSAcUG4Mqln593PcuTWK1sWIhbXU9ZAglKXTzS1ooCFjELBZCpQykSoc6reqGVzrxPO8VZB7C1NaoFUQkXYiu79o40IbexY8',
        'facebook_app_secret' => 'YOUR-FACEBOOK-APP-SECRET-HERE', // Optional - this is used to verify incoming API calls,
    ],
];
