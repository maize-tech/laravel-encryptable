<?php

namespace Maize\Encryptable\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;
use Illuminate\Validation\Rules\Unique;
use Maize\Encryptable\Encryption;

class UniqueEncrypted implements Rule
{
    use ForwardsCalls;

    private Unique $rule;

    public function __construct(string $table, string $column = 'NULL')
    {
        $this->rule = new Unique($table, $column);
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
        return __('validation.unique');
    }
}
