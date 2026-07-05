<?php

return [
    'api_key' => env('FAPSHI_API_KEY', ''),
    'secret_key' => env('FAPSHI_SECRET_KEY', ''),
    'environment' => env('FAPSHI_ENVIRONMENT', 'sandbox'),
    'base_url' => env('FAPSHI_ENVIRONMENT', 'sandbox') === 'production'
        ? 'https://api.fapshi.com'
        : 'https://sandbox.fapshi.com',
    'timeout' => 30,
];
