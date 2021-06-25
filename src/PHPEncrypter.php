<?php

namespace HFarm\Encryptable;

use HFarm\Encryptable\Utils\Serializer;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Contracts\Encryption\EncryptException;
use Illuminate\Support\Str;

class PHPEncrypter extends Encrypter
{
    public function encrypt($value, bool $serialize = true): ?string
    {
        if (is_null($value)) {
            return null;
        }

        if ($this->isEncrypted($value)) {
            return $value;
        }

        if ($serialize) {
            $value = Serializer::serialize($value);
        }

        $value = $this->addDirtyBit($value);

        $value = $this->openSSLEncrypt($value);

        $value = $this->base64Encode($value);

        return $value;
    }

    public function decrypt(?string $payload, bool $unserialize = true)
    {
        if (is_null($payload)) {
            return null;
        }

        if (! $this->isEncrypted($payload)) {
            return $payload;
        }

        $payload = $this->base64Decode($payload);

        $payload = $this->openSSLDecrypt($payload);

        $payload = $this->removeDirtyBit($payload);

        if ($unserialize) {
            $payload = Serializer::unserialize($payload);
        }

        return $payload;
    }

    public function isEncrypted($value): bool
    {
        try {
            $value = $this->base64Decode($value);

            $value = $this->openSSLDecrypt($value);

            return Str::startsWith($value, self::DIRTY_BIT_KEY);
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function addDirtyBit(string $value): string
    {
        return Str::start($value, self::DIRTY_BIT_KEY);
    }

    protected function openSSLEncrypt(string $value): string
    {
        $value = openssl_encrypt(
            $value,
            $this->getEncryptionCipher(),
            $this->getEncryptionKey(),
            OPENSSL_RAW_DATA
        );

        if (! $value) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return $value;
    }

    protected function base64Encode(string $value): string
    {
        $value = base64_encode($value);

        if (! $value) {
            throw new EncryptException('Could not encrypt the data.');
        }

        return $value;
    }

    protected function base64Decode(string $payload): string
    {
        $payload = base64_decode($payload);

        if (! $payload) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return $payload;
    }

    protected function openSSLDecrypt(string $payload): string
    {
        $payload = openssl_decrypt(
            $payload,
            $this->getEncryptionCipher(),
            $this->getEncryptionKey(),
            OPENSSL_RAW_DATA
        );

        if (! $payload) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return $payload;
    }

    protected function removeDirtyBit(string $payload): string
    {
        if (! Str::startsWith($payload, self::DIRTY_BIT_KEY)) {
            throw new DecryptException('Could not decrypt the data.');
        }

        return Str::after($payload, self::DIRTY_BIT_KEY);
    }
}
