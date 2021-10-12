<?php

namespace Maize\Encryptable\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Exists;
use Maize\Encryptable\Encryption;

class ExistsEncrypted extends Exists implements Rule
{
    public function passes($attribute, $value): bool
    {
        $attribute = Str::before($attribute, '.');

        return ! Validator::make([
            $attribute => Encryption::php()->encrypt($value),
        ], [
            $attribute => (string) $this,
        ])->fails();
    }

    public function message(): string
    {
        return 'The selected :attribute is invalid.';
    }
}
