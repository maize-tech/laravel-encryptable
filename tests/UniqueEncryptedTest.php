<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maize\Encryptable\Rules\UniqueEncrypted;


it('should validate encrypted data with custom unique rule', function () {
    $user = $this->createUser();

    $validationFails = Validator::make($user->toArray(), [
        'first_name' => 'unique:users',
    ])->fails();

    expect($validationFails)->toBeFalse();

    $validationFails = Validator::make($user->toArray(), [
        'first_name' => new UniqueEncrypted('users'),
    ])->fails();

    expect($validationFails)->toBeTrue();
});

it('should have rule macro', function () {
    $user = $this->createUser();

    $validationFails = Validator::make($user->toArray(), [
        'first_name' => Rule::uniqueEncrypted('users'),
    ])->fails();

    expect($validationFails)->toBeTrue();
});
