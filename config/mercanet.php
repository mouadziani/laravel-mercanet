<?php

return [
    /**
     * Can only be 'TEST' Or 'Production'. If empty or invalid, 'TEST' will be used.
     */
    'mode' => env('MERCANET_MODE', 'TEST'),

    'test' => [
        'merchant_id' => env('MERCANET_TEST_MERCHANT_ID'),
        'key_version' => env('MERCANET_TEST_KEY_VERSION', '1'),
        'secret_key' => env('MERCANET_TEST_SECRET_KEY'),
    ],

    'production' => [
        'merchant_id' => env('MERCANET_PRODUCTION_MERCHANT_ID'),
        'key_version' => env('MERCANET_PRODUCTION_KEY_VERSION', '1'),
        'secret_key' => env('MERCANET_PRODUCTION_SECRET_KEY'),
    ],

    'currency' => env('MERCANET_CURRENCY', 'USD'),

    'normal_return_url' => env('MERCANET_NORMAL_RETURN_URL'),

    /**
     * Allowed languages 'nl', 'fr', 'de', 'it', 'es', 'cy', 'en'
     */
    'language' => env('MERCANET_LOCALE', 'en'),
];
