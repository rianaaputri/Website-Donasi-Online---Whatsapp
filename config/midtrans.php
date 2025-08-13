<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for Midtrans such as server key,
    | client key, production mode, and additional settings for transaction
    | security and environment.
    |
    */

    'server_key'     => env('MIDTRANS_SERVER_KEY', ''),
    'client_key'     => env('MIDTRANS_CLIENT_KEY', ''),
    'is_production'  => env('MIDTRANS_IS_PRODUCTION', false),
    'merchant_id'    => env('MIDTRANS_MERCHANT_ID', ''),
    'snap_url'       => env('MIDTRANS_IS_PRODUCTION', false) 
        ? 'https://app.midtrans.com/snap/snap.js' 
        : 'https://app.sandbox.midtrans.com/snap/snap.js',
];
