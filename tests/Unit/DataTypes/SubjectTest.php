<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\Subject;
use Tests\TestCase;

class SubjectTest  extends TestCase
{
    public function test_url()
    {
        $subject = new Subject($url = 'https://google.com');

        $this->assertEquals($url, $subject->url);
    }

    public function test_html()
    {
        $subject = new Subject(
            $html = '<div>Some Content</div>',
            $filename = 'test.html'
        );

        $this->assertEquals($html, $subject->html);
        $this->assertEquals($filename, $subject->filename);
    }
}