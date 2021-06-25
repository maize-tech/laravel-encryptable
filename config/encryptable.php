<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Encryption key
    |--------------------------------------------------------------------------
    |
    | The key used to encrypt data.
    | Once defined, never change it or encrypted data cannot be correctly decrypted.
    |
    */

    'key' => env('ENCRYPTION_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Encryption cipher
    |--------------------------------------------------------------------------
    |
    | The cipher used to encrypt data.
    | Once defined, never change it or encrypted data cannot be correctly decrypted.
    | Default value is the cipher algorithm used by default in MySQL.
    |
    */

    'cipher' => env('ENCRYPTION_CIPHER', 'aes-128-ecb'),
];
