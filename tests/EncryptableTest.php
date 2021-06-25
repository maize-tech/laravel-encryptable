<?php

namespace HFarm\Encryptable\Tests;

use HFarm\Encryptable\Encryption;
use HFarm\Encryptable\Tests\Models\User;
use Illuminate\Support\Facades\DB;

class EncryptableTest extends TestCase
{
    /** @test */
    public function it_should_encrypt_data_when_saving_model_instance()
    {
        $user = $this->createUser();

        $this->assertDatabaseCount($user->getTable(), 1);

        $userRaw = DB::table($user->getTable())
            ->select('*')
            ->where('id', $user->getKey())
            ->first();

        $this->assertTrue(
            Encryption::isEncrypted($userRaw->first_name)
        );

        $this->assertTrue(
            Encryption::isEncrypted($userRaw->last_name)
        );
    }

    /** @test */
    public function it_should_decrypt_data_when_retrieving_models()
    {
        $user = $this->createUser();

        $this->assertDatabaseCount($user->getTable(), 1);

        $user = User::findOrFail($user->getKey());

        $this->assertEquals('Name', $user->first_name);

        $this->assertEquals('Surname', $user->last_name);
    }
}
