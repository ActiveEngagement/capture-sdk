<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\Viewport;
use Tests\TestCase;

class ViewportTest extends TestCase
{
    public function test_viewport()
    {
        $viewport = new Viewport(
            $width = 800,
            $height = 600,
        );

        $this->assertEquals($width, $viewport->width);
        $this->assertEquals($height, $viewport->height);
    }
}