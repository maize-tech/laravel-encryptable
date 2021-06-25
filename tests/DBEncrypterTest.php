<?php

namespace HFarm\Encryptable\Tests;

use HFarm\Encryptable\Encryption;
use Illuminate\Contracts\Encryption\EncryptException;

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
