<?php

namespace Maize\Encryptable\Tests;

use Maize\Encryptable\Exceptions\SerializationException;
use Maize\Encryptable\Exceptions\UnserializationException;
use Maize\Encryptable\Utils\Serializer;

class SerializerTest extends TestCase
{
    /** @test */
    public function it_should_throw_exception_when_serializing_unsupported_type()
    {
        $this->expectException(SerializationException::class);

        Serializer::serialize(['test array']);
    }

    /** @test */
    public function it_should_serialize_all_supported_values()
    {
        $this->assertEquals(
            'string:test',
            Serializer::serialize('test')
        );

        $this->assertEquals(
            'string:test:test',
            Serializer::serialize('test:test')
        );

        $this->assertEquals(
            'integer:1',
            Serializer::serialize(1)
        );

        $this->assertEquals(
            'double:1.3',
            Serializer::serialize(1.3)
        );

        $this->assertEquals(
            'boolean:1',
            Serializer::serialize(true)
        );
    }

    /** @test */
    public function it_should_throw_exception_when_unserializing_invalid_value()
    {
        $this->expectException(UnserializationException::class);

        Serializer::unserialize('test');
    }

    /** @test */
    public function it_should_unserialize_all_supported_values()
    {
        $string = Serializer::unserialize('string:test');
        $this->assertIsString($string);
        $this->assertEquals('test', $string);

        $string = Serializer::unserialize('string:test:test');
        $this->assertIsString($string);
        $this->assertEquals('test:test', $string);

        $integer = Serializer::unserialize('integer:1');
        $this->assertIsInt($integer);
        $this->assertEquals(1, $integer);

        $double = Serializer::unserialize('double:1.3');
        $this->assertIsFloat($double);
        $this->assertEquals(1.3, $double);

        $boolean = Serializer::unserialize('boolean:1');
        $this->assertIsBool($boolean);
        $this->assertEquals(true, $boolean);
    }
}
