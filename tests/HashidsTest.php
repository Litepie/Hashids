<?php

namespace Litepie\Hashids\Tests;

use Litepie\Hashids\Facades\Hashids;

class HashidsTest extends TestCase
{
    /** @test */
    public function it_can_encode_and_decode_numbers()
    {
        $encoded = hashids_encode(123);
        $this->assertIsString($encoded);
        
        $decoded = hashids_decode($encoded);
        $this->assertEquals(123, $decoded);
    }

    /** @test */
    public function it_can_encode_and_decode_multiple_numbers()
    {
        $numbers = [123, 456, 789];
        $encoded = hashids_encode($numbers);
        $this->assertIsString($encoded);
        
        $decoded = hashids_decode($encoded);
        $this->assertEquals($numbers, $decoded);
    }

    /** @test */
    public function it_can_use_facade()
    {
        $encoded = Hashids::encode(123);
        $this->assertIsString($encoded);
        
        $decoded = Hashids::decode($encoded);
        $this->assertEquals([123], $decoded);
    }

    /** @test */
    public function it_returns_null_for_invalid_hashids()
    {
        $decoded = hashids_decode('invalid');
        $this->assertNull($decoded);
    }

    /** @test */
    public function it_can_encode_and_decode_hex()
    {
        $hex = 'ff';
        $encoded = hashids_encode_hex($hex);
        $this->assertIsString($encoded);
        
        $decoded = hashids_decode_hex($encoded);
        $this->assertEquals($hex, $decoded);
    }
}
