<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\ContentType;
use Tests\TestCase;

class ContentTypeTest extends TestCase
{
    public function test_content_type()
    {
        $this->assertEquals('application/json', ContentType::JSON->value);
        $this->assertEquals('text/plain', ContentType::Plain->value);
    }
}