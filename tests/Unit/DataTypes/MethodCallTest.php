<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\MethodCall;
use Tests\TestCase;

class MethodCallTest  extends TestCase
{
    public function test_method_call()
    {
        $methodCall = new MethodCall(
            $method = 'test', $args = [1, 2, 3]
        );

        $this->assertEquals($method, $methodCall->method);
        $this->assertEquals($args, $methodCall->args);
    }
}