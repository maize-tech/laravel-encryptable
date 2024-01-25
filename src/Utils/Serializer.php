<?php

namespace Maize\Encryptable\Utils;

use Maize\Encryptable\Exceptions\SerializationException;
use Maize\Encryptable\Exceptions\UnserializationException;

class Serializer
{
    const SUPPORTED_TYPES = [
        'string',
        'integer',
        'double',
        'boolean',
    ];

    public static function serialize($value): string
    {
        $valueType = gettype($value);

        if (! in_array($valueType, self::SUPPORTED_TYPES)) {
            throw new SerializationException();
        }

        $value = strval($value);

        return "{$valueType}:{$value}";
    }

    public static function unserialize(string $payload)
    {
        $payload = explode(':', $payload, 2);

        if (count($payload) !== 2) {
            throw new UnserializationException();
        }

        [$valueType, $value] = $payload;

        if (! settype($value, $valueType)) {
            throw new UnserializationException();
        }

        return $value;
    }
}
