<?php

use Illuminate\Support\Facades\DB;
use Maize\Encryptable\Encryption;
use Maize\Encryptable\Tests\Models\User;


it('should encrypt data when saving model instance', function () {
    $user = $this->createUser();

    $this->assertDatabaseCount($user->getTable(), 1);

    $userRaw = DB::table($user->getTable())
        ->select('*')
        ->where('id', $user->getKey())
        ->first();

    expect(Encryption::isEncrypted($userRaw->first_name))->toBeTrue();

    expect(Encryption::isEncrypted($userRaw->last_name))->toBeTrue();
});

it('should encrypt data when updating model instance', function () {
    $user = $this->createUser();

    $user->update([
        'first_name' => 'Test',
    ]);

    $userRaw = DB::table($user->getTable())
        ->select('*')
        ->where('id', $user->getKey())
        ->first();

    expect(Encryption::isEncrypted($userRaw->first_name))->toBeTrue();

    expect(Encryption::php()->decrypt($userRaw->first_name))->toEqual('Test');
});

it('should decrypt data when retrieving models', function () {
    $user = $this->createUser();

    $this->assertDatabaseCount($user->getTable(), 1);

    $user = User::findOrFail($user->getKey());

    expect($user->first_name)->toEqual('Name');

    expect($user->last_name)->toEqual('Surname');
});
