<?php

namespace Maize\Encryptable;

use Illuminate\Validation\Rule;
use Maize\Encryptable\Rules\ExistsEncrypted;
use Maize\Encryptable\Rules\UniqueEncrypted;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class EncryptableServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-encryptable')
            ->hasConfigFile();
    }

    public function bootingPackage()
    {
        Rule::macro(
            'uniqueEncrypted',
            fn (string $table, string $column = 'NULL') => new UniqueEncrypted($table, $column)
        );

        Rule::macro(
            'existsEncrypted',
            fn (string $table, string $column = 'NULL') => new ExistsEncrypted($table, $column)
        );
    }
}
