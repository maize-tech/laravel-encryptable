<?php

namespace Maize\Encryptable;

use Maize\Encryptable\Exceptions\MissingEncryptionCipherException;
use Maize\Encryptable\Exceptions\MissingEncryptionKeyException;

abstract class Encrypter
{
    const DIRTY_BIT_KEY = 'crypt:';

    abstract public function encrypt($value, bool $serialize = true): ?string;

    abstract public function decrypt(?string $payload, bool $unserialize = true);

    protected function getEncryptionKey(): string
    {
        $key = config('encryptable.key');

        if (empty($key)) {
            throw new MissingEncryptionKeyException();
        }

        return (string) $key;
    }

    protected function getEncryptionCipher(): string
    {
        $cipher = config('encryptable.cipher');

        if (empty($cipher)) {
            throw new MissingEncryptionCipherException();
        }

        return (string) $cipher;
    }
}
