<?php

namespace Maize\Encryptable\Tests;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maize\Encryptable\Rules\UniqueEncrypted;

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

    /** @test */
    public function it_should_have_rule_macro()
    {
        $user = $this->createUser();

        $validationFails = Validator::make($user->toArray(), [
            'first_name' => Rule::uniqueEncrypted('users'),
        ])->fails();

        $this->assertTrue($validationFails);
    }
}
