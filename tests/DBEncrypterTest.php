<?php

use Illuminate\Contracts\Encryption\EncryptException;
use Maize\Encryptable\Encryption;


it('should throw exception on db encrypt', function () {
    $this->expectException(EncryptException::class);

    Encryption::db()->encrypt('test');
});

it('should return query on db decrypt', function () {
    $query = Encryption::db()->decrypt('test');

    expect($query)->toBeString();
});
