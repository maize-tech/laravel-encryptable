<p align="center"><img src="/art/socialcard.png" alt="Social Card of Laravel Encryptable"></p>

# Laravel Encryptable

[![Latest Version on Packagist](https://img.shields.io/packagist/v/h-farm/laravel-encryptable.svg?style=flat-square)](https://packagist.org/packages/h-farm/laravel-encryptable)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/h-farm/laravel-encryptable/run-tests?label=tests)](https://github.com/h-farm/laravel-encryptable/actions?query=workflow%3ATests+branch%3Amaster)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/h-farm/laravel-encryptable/Check%20&%20fix%20styling?label=code%20style)](https://github.com/h-farm/laravel-encryptable/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amaster)
[![Total Downloads](https://img.shields.io/packagist/dt/h-farm/laravel-encryptable.svg?style=flat-square)](https://packagist.org/packages/h-farm/laravel-encryptable)


This package allows you to anonymize sensitive data (like the name, surname and email address of a user) similarly to Laravel's Encryption feature, but still have the ability to make direct queries to the database.
An example use case could be the need to make search queries through anonymized attributes.

This package currently supports `MySQL` and `PostgreSQL` databases.

## Installation

You can install the package via composer:

```bash
composer require h-farm/laravel-encryptable
```

You can publish the config file with:
```bash
php artisan vendor:publish --provider="HFarm\Encryptable\EncryptableServiceProvider" --tag="encryptable-config"
```

This is the content of the published config file:

```php
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
```

## Usage

### Basic

To use the package, just add the `Encryptable` cast to all model attributes you want to anonymize.

``` php
<?php

namespace App\Models;

use HFarm\Encryptable\Encryptable;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'email',
    ];

    protected $casts = [
        'name' => Encryptable::class,
        'email' => Encryptable::class,
    ];
}
```

Once done, all values will be encrypted before being stored in the database, and decrypted when querying them via Eloquent.

### Manually encrypt via PHP

``` php
use HFarm\Encryptable\Encryption;

$value = "your-decrypted-value";

$encrypted = Encryption::php()->encrypt($value); // returns the encrypted value
```

### Manually decrypt via PHP

``` php
use HFarm\Encryptable\Encryption;

$encrypted = "your-encrypted-value";

$value = Encryption::php()->decrypt($value); // returns the decrypted value
```

### Manually decrypt via DB

``` php
use HFarm\Encryptable\Encryption;

$encrypted = "your-encrypted-value";

$encryptedQuery = Encryption::db()->encrypt($value); // returns the query used to find the decrypted value
```

### Custom validation rules

You can use one of the two custom rules to check the uniqueness or existence of a given encryptable value.

`ExistsEncrypted` is an extension of Laravel's `Exists` rule, whereas `UniqueEncrypted` is an extension of Laravel's `Unique` rule.
You can use them in the same way as Laravel's base rules:
``` php
use HFarm\Encryptable\Rules\ExistsEncrypted;
use Illuminate\Support\Facades\Validator;

$data = [
    'email' => 'email@example.com',
];

Validator::make($data, [
    'email' => [
        'required',
        'string',
        'email',
        new ExistsEncrypted('users'), // checks whether the given email exists in the database
    ],
]);
```

``` php
use HFarm\Encryptable\Rules\UniqueEncrypted;
use Illuminate\Support\Facades\Validator;

$data = [
    'email' => 'email@example.com',
];

Validator::make($data, [
    'email' => [
        'required',
        'string',
        'email',
        new UniqueEncrypted('users'), // checks whether the given email does not already exist in the database
    ],
]);
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Enrico De Lazzari](https://github.com/enricodelazzari)
- [Riccardo Dalla Via](https://github.com/riccardodallavia)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
