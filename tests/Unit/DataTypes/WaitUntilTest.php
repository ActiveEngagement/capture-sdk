<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\WaitUntil;
use Tests\TestCase;

class WaitUntilTest extends TestCase
{
    public function test_type()
    {
        $this->assertEquals('load', WaitUntil::Load->value);
        $this->assertEquals('domcontentloaded', WaitUntil::DomContentLoaded->value);
        $this->assertEquals('networkidle0', WaitUntil::NetworkdIdle0->value);
        $this->assertEquals('networkidle2', WaitUntil::NetworkdIdle2->value);
    }
}