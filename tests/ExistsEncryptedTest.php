<?php

namespace Maize\Encryptable\Tests;

use Illuminate\Support\Facades\Validator;
use Maize\Encryptable\Rules\ExistsEncrypted;

class ExistsEncryptedTest extends TestCase
{
    /** @test */
    public function it_should_validate_encrypted_data_with_custom_exists_rule()
    {
        $user = $this->createUser();

        $validationFails = Validator::make($user->toArray(), [
            'first_name' => 'exists:users',
        ])->fails();

        $this->assertTrue($validationFails);

        $validationFails = Validator::make($user->toArray(), [
            'first_name' => new ExistsEncrypted('users'),
        ])->fails();

        $this->assertFalse($validationFails);
    }
}
