<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\Clip;
use Tests\TestCase;

class ClipTest extends TestCase
{
    public function test_clip()
    {
        $clip = new Clip(
            $width = 800,
            $height = 600,
            $x = 400,
            $y = 300
        );

        $this->assertEquals($width, $clip->width);
        $this->assertEquals($height, $clip->height);
        $this->assertEquals($x, $clip->x);
        $this->assertEquals($y, $clip->y);
    }
}