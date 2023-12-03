<?php

return [
    'mode' => env('PAYMENT_GATEWAY_MODE', 'dev'),

    'webhook' => [
        'endpoint' => env('PAYMENT_GATEWAY_DOMAIN', 'http://localhost:8000') . '/api/' . env('PAYMENT_GATEWAY_VERSION', null) . '/webhook'
    ],

    'zoop' => [
        'credential' => [
            'marketplace_id' => env('ZOOP_MARKETPLACE_ID', null),
            'seller_id' => env('ZOOP_SELLER_ID', null),
            'publisable_key' => env('ZOOP_PUBLISHABLE_KEY', null),
            'email' => env('ZOOP_EMAIL', null),
            'password' => env('ZOOP_PASSWORD', null),
        ],
    ],

    'openpix' => [
        'credential' => [
            'client_id' => env('OPENPIX_CLIENT_ID', null),
            'app_id' => env('OPENPIX_APP_ID', null),
        ],
    ],

    'mercadopago' => [
        'credential' => [
            'token' => env('MERCADOPAGO_TOKEN', null),
        ],
    ],
];
