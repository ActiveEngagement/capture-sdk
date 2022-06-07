<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\Encoding;
use Tests\TestCase;

class EncodingTest extends TestCase
{
    public function test_encoding()
    {
        $this->assertEquals('base64', Encoding::Base64->value);
        $this->assertEquals('binary', Encoding::Binary->value);
    }
}