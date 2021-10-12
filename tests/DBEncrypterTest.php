<?php

namespace Maize\Encryptable\Tests;

use Illuminate\Contracts\Encryption\EncryptException;
use Maize\Encryptable\Encryption;

class DBEncrypterTest extends TestCase
{
    /** @test */
    public function it_should_throw_exception_on_db_encrypt()
    {
        $this->expectException(EncryptException::class);

        Encryption::db()->encrypt('test');
    }

    /** @test */
    public function it_should_return_query_on_db_decrypt()
    {
        $query = Encryption::db()->decrypt('test');

        $this->assertIsString($query);
    }
}
