<?php

namespace HFarm\Encryptable\Rules;

use HFarm\Encryptable\Encryption;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;

class ExistsEncrypted extends Exists implements Rule
{
    public function passes($attribute, $value): bool
    {
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
