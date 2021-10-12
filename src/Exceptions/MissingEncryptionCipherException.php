<?php

namespace Maize\Encryptable\Exceptions;

use RuntimeException;

class MissingEncryptionCipherException extends RuntimeException
{
    public function __construct(string $message = 'No encryption cipher has been specified.')
    {
        parent::__construct($message);
    }
}
