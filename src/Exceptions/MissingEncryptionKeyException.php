<?php

namespace HFarm\Encryptable\Exceptions;

use RuntimeException;

class MissingEncryptionKeyException extends RuntimeException
{
    public function __construct(string $message = 'No encryption key has been specified.')
    {
        parent::__construct($message);
    }
}
