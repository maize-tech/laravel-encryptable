<?php

namespace HFarm\Encryptable\Tests;

use HFarm\Encryptable\Rules\UniqueEncrypted;
use Illuminate\Support\Facades\Validator;

class UniqueEncryptedTest extends TestCase
{
    /** @test */
    public function it_should_validate_encrypted_data_with_custom_unique_rule()
    {
        $user = $this->createUser();

        $validationFails = Validator::make($user->toArray(), [
            'first_name' => 'unique:users',
        ])->fails();

        $this->assertFalse($validationFails);

        $validationFails = Validator::make($user->toArray(), [
            'first_name' => new UniqueEncrypted('users'),
        ])->fails();

        $this->assertTrue($validationFails);
    }
}
