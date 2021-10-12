<?php

namespace Maize\Encryptable;

class Encryption
{
    private $encrypter;

    public function __construct($encrypter)
    {
        $this->encrypter = $encrypter;
    }

    public static function php(): self
    {
        return new static(
            app(PHPEncrypter::class)
        );
    }

    public static function db(): self
    {
        return new static(
            app(DBEncrypter::class)
        );
    }

    public static function isEncrypted($value): bool
    {
        return self::php()->encrypter
            ->isEncrypted($value);
    }

    public function encrypt($value, bool $serialize = true)
    {
        return $this->encrypter
            ->encrypt($value, $serialize);
    }

    public function decrypt(?string $payload, bool $unserialize = true)
    {
        return $this->encrypter
            ->decrypt($payload, $unserialize);
    }
}
