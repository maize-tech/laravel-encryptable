<?php

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maize\Encryptable\Rules\ExistsEncrypted;


it('should validate encrypted data with custom exists rule', function () {
    $user = $this->createUser();

    $validationFails = Validator::make($user->toArray(), [
        'first_name' => 'exists:users',
    ])->fails();

    expect($validationFails)->toBeTrue();

    $validationFails = Validator::make($user->toArray(), [
        'first_name' => new ExistsEncrypted('users'),
    ])->fails();

    expect($validationFails)->toBeFalse();
});

it('should have rule macro', function () {
    $user = $this->createUser();

    $validationFails = Validator::make($user->toArray(), [
        'first_name' => Rule::existsEncrypted('users'),
    ])->fails();

    expect($validationFails)->toBeFalse();
});
