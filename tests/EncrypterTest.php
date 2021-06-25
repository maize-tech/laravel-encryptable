<?php

namespace HFarm\Encryptable\Tests;

use HFarm\Encryptable\Encryption;
use HFarm\Encryptable\Exceptions\MissingEncryptionCipherException;
use HFarm\Encryptable\Exceptions\MissingEncryptionKeyException;

class EncrypterTest extends TestCase
{
    /** @test */
    public function it_should_throw_exception_when_encryption_key_is_missing()
    {
        config()->set('encryptable.key', null);

        $this->expectException(MissingEncryptionKeyException::class);

        Encryption::php()->encrypt('test');
    }

    /** @test */
    public function it_should_throw_exception_when_encryption_cipher_is_missing()
    {
        config()->set('encryptable.cipher', null);

        $this->expectException(MissingEncryptionCipherException::class);

        Encryption::db()->decrypt('test');
    }
}
