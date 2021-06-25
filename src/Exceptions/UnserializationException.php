<?php

namespace HFarm\Encryptable\Exceptions;

use RuntimeException;

class UnserializationException extends RuntimeException
{
    public function __construct(string $message = 'The given value cannot be unserialized.')
    {
        parent::__construct($message);
    }
}
