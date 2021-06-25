<?php

namespace HFarm\Encryptable\Exceptions;

use RuntimeException;

class SerializationException extends RuntimeException
{
    public function __construct(string $message = 'The given value cannot be serialized.')
    {
        parent::__construct($message);
    }
}
