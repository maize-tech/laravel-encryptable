<?php

use Maize\Encryptable\Encryption;
use Maize\Encryptable\Exceptions\MissingEncryptionCipherException;
use Maize\Encryptable\Exceptions\MissingEncryptionKeyException;

it('should throw exception when encryption key is missing', function () {
    config()->set('encryptable.key', null);

    $this->expectException(MissingEncryptionKeyException::class);

    Encryption::php()->encrypt('test');
});

it('should throw exception when encryption cipher is missing', function () {
    config()->set('encryptable.cipher', null);

    $this->expectException(MissingEncryptionCipherException::class);

    Encryption::db()->decrypt('test');
});
