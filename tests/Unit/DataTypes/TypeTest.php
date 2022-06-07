<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\Type;
use Tests\TestCase;

class TypeTest extends TestCase
{
    public function test_type()
    {
        $this->assertEquals('jpeg', Type::JPEG->value);
        $this->assertEquals('png', Type::PNG->value);
    }
}