<?php

use Maize\Encryptable\Exceptions\SerializationException;
use Maize\Encryptable\Exceptions\UnserializationException;
use Maize\Encryptable\Utils\Serializer;

it('should throw exception when serializing unsupported type', function () {
    $this->expectException(SerializationException::class);

    Serializer::serialize(['test array']);
});

it('should serialize all supported values', function () {
    expect(Serializer::serialize('test'))->toEqual('string:test');

    expect(Serializer::serialize('test:test'))->toEqual('string:test:test');

    expect(Serializer::serialize(1))->toEqual('integer:1');

    expect(Serializer::serialize(1.3))->toEqual('double:1.3');

    expect(Serializer::serialize(true))->toEqual('boolean:1');
});

it('should throw exception when unserializing invalid value', function () {
    $this->expectException(UnserializationException::class);

    Serializer::unserialize('test');
});

it('should unserialize all supported values', function () {
    $string = Serializer::unserialize('string:test');
    expect($string)->toBeString();
    expect($string)->toEqual('test');

    $string = Serializer::unserialize('string:test:test');
    expect($string)->toBeString();
    expect($string)->toEqual('test:test');

    $integer = Serializer::unserialize('integer:1');
    expect($integer)->toBeInt();
    expect($integer)->toEqual(1);

    $double = Serializer::unserialize('double:1.3');
    expect($double)->toBeFloat();
    expect($double)->toEqual(1.3);

    $boolean = Serializer::unserialize('boolean:1');
    expect($boolean)->toBeBool();
    expect($boolean)->toEqual(true);
});
