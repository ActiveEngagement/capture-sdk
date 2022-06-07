<?php

namespace Tests\Unit;

use Actengage\Capture\DataTypes\Clip;
use Actengage\Capture\DataTypes\Encoding;
use Actengage\Capture\DataTypes\Type;
use Actengage\Capture\DataTypes\Viewport;
use Actengage\Capture\DataTypes\WaitUntil;
use Actengage\Capture\Facades\Screenshot;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use InvalidArgumentException;
use Tests\TestCase;

class ScreenshotFactoryTest extends TestCase
{
    public function test_factory_request()
    {
        // Create a mock and queue two responses.
        $mock = new MockHandler([
            new Response(200, [], fopen(__DIR__.'/../src/google.jpg', 'r'))
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new Client([
            'handler' => $handlerStack
        ]);

        $factory = Screenshot::make('<div>test</div>', 'test.html')
            ->client($client)
            ->call('test', [1, 2, 3])
            ->clip(new Clip(800, 600, 400, 300))
            ->encoding(Encoding::Binary)
            ->header('Some-Header', 'some value')
            ->omitBackground(false)
            ->quality(75)
            ->timeout(15000)
            ->type(Type::PNG)
            ->viewport(new Viewport(1200, 800))
            ->waitUntil(WaitUntil::Load);
        
        $response = $factory->request();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_invalid_quality_over_100()
    {
        $this->expectException(InvalidArgumentException::class);
        
        Screenshot::make('https://google.com')->quality(105);
    }

    public function test_invalid_quality_under_1()
    {
        $this->expectException(InvalidArgumentException::class);
        
        Screenshot::make('https://google.com')->quality(0);
    }
}