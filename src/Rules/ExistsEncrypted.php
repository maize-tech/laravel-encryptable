<?php

namespace Maize\Encryptable\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Validation\Rules\Exists;
use Maize\Encryptable\Encryption;

class ExistsEncrypted implements Rule
{
    use ForwardsCalls;

    private Exists $rule;

    public function __construct(string $table, string $column = 'NULL')
    {
        $this->rule = new Exists($table, $column);
    }

    public function __call(string $name, array $arguments)
    {
        $this->forwardCallTo($this->rule, $name, $arguments);

        return $this;
    }

    public function passes($attribute, $value): bool
    {
        $attribute = Str::before($attribute, '.');

        return ! Validator::make([
            $attribute => Encryption::php()->encrypt($value),
        ], [
            $attribute => $this->rule,
        ])->fails();
    }

    public function message(): string
    {
        return 'The selected :attribute is invalid.';
    }
}
