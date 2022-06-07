<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\HttpHeader;
use Tests\TestCase;

class HttpHeaderTest  extends TestCase
{
    public function test_http_header()
    {
        $httpHeader = new HttpHeader(
            $key = 'Content-Type', $value = 'application/json'
        );

        $this->assertEquals($key, $httpHeader->key);
        $this->assertEquals($value, $httpHeader->value);
    }
}