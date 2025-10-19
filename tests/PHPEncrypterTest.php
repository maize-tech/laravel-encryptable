<?php

use Maize\Encryptable\Encryption;


it('should not encrypt already encrypted value', function () {
    $value = Encryption::php()->encrypt('test');

    expect(Encryption::php()->encrypt($value))->toEqual($value);
});

it('should return a string when encrypting value', function () {
    $value = Encryption::php()->encrypt('test');

    expect($value)->toBeString();

    expect(Encryption::isEncrypted($value))->toBeTrue();
});

it('should not decrypt an unencrypted value', function () {
    expect(Encryption::php()->decrypt('test'))->toEqual('test');
});

it('should return value when decrypting value', function () {
    $value = Encryption::php()->encrypt(false);

    expect(Encryption::php()->decrypt($value))->toBeBool();

    expect(Encryption::php()->decrypt($value))->toEqual(false);
});
