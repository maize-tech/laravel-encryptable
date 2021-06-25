<?php

namespace HFarm\Encryptable\Tests;

use HFarm\Encryptable\Encryption;

class PHPEncrypterTest extends TestCase
{
    /** @test */
    public function it_should_not_encrypt_already_encrypted_value()
    {
        $value = Encryption::php()->encrypt('test');

        $this->assertEquals(
            $value,
            Encryption::php()->encrypt($value)
        );
    }

    /** @test */
    public function it_should_return_a_string_when_encrypting_value()
    {
        $value = Encryption::php()->encrypt('test');

        $this->assertIsString($value);

        $this->assertTrue(
            Encryption::isEncrypted($value)
        );
    }

    /** @test */
    public function it_should_not_decrypt_an_unencrypted_value()
    {
        $this->assertEquals(
            'test',
            Encryption::php()->decrypt('test')
        );
    }

    /** @test */
    public function it_should_return_value_when_decrypting_value()
    {
        $value = Encryption::php()->encrypt(false);

        $this->assertIsBool(
            Encryption::php()->decrypt($value)
        );

        $this->assertEquals(
            false,
            Encryption::php()->decrypt($value)
        );
    }
}
