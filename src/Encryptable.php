<?php

namespace HFarm\Encryptable;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Encryptable implements CastsAttributes
{
    public function get($model, string $key, $value, array $attributes)
    {
        return Encryption::php()->decrypt($value);
    }

    public function set($model, string $key, $value, array $attributes)
    {
        return Encryption::php()->encrypt($value);
    }
}
