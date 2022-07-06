<?php

namespace Actengage\Capture;

use Actengage\Capture\Contracts\Multipartable;
use Actengage\Capture\DataTypes\Clip;
use Actengage\Capture\DataTypes\Encoding;
use Actengage\Capture\DataTypes\HttpHeader;
use Actengage\Capture\DataTypes\MethodCall;
use Actengage\Capture\DataTypes\MultipartData;
use Actengage\Capture\DataTypes\Subject;
use Actengage\Capture\DataTypes\Type;
use Actengage\Capture\DataTypes\Viewport;
use Actengage\Capture\DataTypes\WaitUntil;
use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class ScreenshotFactory implements Arrayable
{
    /**
     * A stack of method calls for Puppeteer before the screenshot is taken.
     *
     * @var \Illuminate\Support\Collection<MethodCall>
     */
    public Collection $calls;

    /**
     * Clip the image to a specific size and coordinate.
     *
     * @var \Actengage\Capture\DataTypes\Clip|null
     */
    public ?Clip $clip = null;

    /**
     * The Guzzle HTTP client.
     *
     * @var \GuzzleHttp\Client
     */
    public Client $client;

    /**
     * The file encoding.
     *
     * @var \Actengage\Capture\DataTypes\Encoding
     */
    public Encoding $encoding = Encoding::Binary;

    /**
     * The Capture server endpoint url.
     *
     * @var string
     */
    public string $endpoint;

    /**
     * Should take a fullPage screen.
     *
     * @var boolean
     */
    public bool $fullPage = false;

    /**
     * Extra HTTP headers sent to Puppeteer.
     *
     * @var \Illuminate\Support\Collection<HttpHeader>
     */
    public Collection $headers;

    /**
     * Omit the background for PNG images.
     *
     * @var boolean
     */
    public bool $omitBackground = true;

    /**
     * The image quality (1-100).
     *
     * @var integer
     */
    public int $quality = 100;

    /**
     * The subject used to capture the screenshot.
     *
     * @var \Actengage\Capture\DataTypes\Subject
     */
    public Subject $subject;

    /**
     * The browser timeout (in milliseconds).
     *
     * @var integer|null
     */
    public ?int $timeout = null;

    /**
     * The image type (jpeg or png).
     *
     * @var \Actengage\Capture\DataTypes\Type
     */
    public Type $type = Type::JPEG;

    /**
     * The browser viewport size.
     *
     * @var Viewport|null
     */
    public ?Viewport $viewport = null;

    /**
     * How long the browser will wait for a response.
     *
     * @var WaitUntil|array<WaitUntil>|null
     */
    public WaitUntil|array|null $waitUntil = null;

    /**
     * Create a new instance.
     *
     * @param string $subject
     * @param string|null $filename
     */
    public function __construct(string $subject = null, ?string $filename = null)
    {
        $this->client(new Client());
        $this->calls(collect());
        $this->headers(collect());
        $this->endpoint(config('capture.endpoint', 'https://localhost:3000'));

        if(!is_null($subject)) {
            $this->subject($subject, $filename);
        }
    }

    /**
     * Add a method call to the stack.
     *
     * @param string $method
     * @param mixed ...$args
     * @return self
     */
    public function call(string $method, ...$args): self
    {
        $this->calls->push(new MethodCall($method, $args));

        return $this;
    }

    /**
     * Set the `calls` property.
     *
     * @param \Illuminate\Support\Collection $calls
     * @return self
     */
    public function calls(Collection $calls): self
    {
        $this->calls = $calls;

        return $this;
    }

    /**
     * Set the `client` proeprty.
     *
     * @param \GuzzleHttp\Client $client
     * @return self;
     */
    public function client(Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Set the `clip` property.
     *
     * @param Clip|null $clip
     * @return self
     */
    public function clip(?Clip $clip): self
    {
        $this->clip = $clip;

        return $this;
    }

    /**
     * Set the `encoding` property.
     *
     * @param \Actengage\Capture\DataTypes\Encoding $encoding
     * @return self
     */
    public function encoding(Encoding $encoding): self
    {
        $this->encoding = $encoding;

        return $this;
    }

    /**
     * Set the `endpoint` property.
     *
     * @param string $endpoint
     * @return self
     */
    public function endpoint(string $endpoint): self
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Add a header to Puppeteer.
     *
     * @param string $key
     * @param string $value
     * @return self
     */
    public function header(string $key, string $value): self
    {
        $this->headers[] = new HttpHeader($key, $value);

        return $this;
    }

    /**
     * The HTTP headers that will be send by Puppeteer.
     *
     * @param \Illuminate\Support\Collection $headers
     * @return self
     */
    public function headers(Collection $headers): self
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * Set the `fullPage` property.
     *
     * @param boolean $fullPage
     * @return self
     */
    public function fullPage(bool $fullPage = true): self
    {
        $this->fullPage = $fullPage;

        return $this;
    }

    /**
     * Set the `omitBackground` property.
     *
     * @param boolean $omitBackground
     * @return self
     */
    public function omitBackground(bool $omitBackground = true): self
    {
        $this->omitBackground = $omitBackground;

        return $this;
    }

    /**
     * Send the HTTP request.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function request(): ResponseInterface
    {
        return $this->client->request('POST', $this->endpoint, [
            'multipart' => $this->toMultipart()
        ]);
    }

    /**
     * Set the `quality` property.
     *
     * @param integer $quality
     * @return self
     */
    public function quality(int $quality): self
    {
        if($quality < 1 || $quality > 100) {
            throw new InvalidArgumentException(
                'The quality must be between 1-100'
            );
        }

        $this->quality = $quality;

        return $this;
    }

    /**
     * Set the `subject` property.
     *
     * @param mixed $subject
     * @param string|null $filename
     * @return self
     */
    public function subject(mixed $subject, ?string $filename = null): self
    {
        $this->subject = new Subject($subject, $filename);

        return $this;
    }

    /**
     * Set the `timeout` property.
     *
     * @param integer|null $timeout
     * @return self
     */
    public function timeout(?int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    /**
     * Set the `type` property.
     *
     * @param \Actengage\Capture\DataTypes\Type $Type
     * @return self
     */
    public function type(Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Set the `viewport` property.
     *
     * @param Viewport|null $viewport
     * @return self
     */
    public function viewport(?Viewport $viewport): self
    {
        $this->viewport = $viewport;

        return $this;
    }

    /**
     * Set the `waitUntil` property.
     *
     * @param WaitUntil|array<WaitUntil>|null $waitUntil
     * @return self
     */
    public function waitUntil(WaitUntil|array|null $waitUntil): self
    {    
        if($waitUntil && !is_array($waitUntil)) {
            $waitUntil = [$waitUntil];
        }

        $this->waitUntil = $waitUntil;

        return $this;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'calls' => $this->calls,
            'clip' => $this->clip,
            'encoding' => $this->encoding->value,
            'fullPage' => $this->fullPage,
            'headers' => $this->headers,
            'omitBackground' => $this->omitBackground,
            'quality' => $this->quality,
            'subject' => $this->subject,
            'timeout' => $this->timeout,
            'type' => $this->type->value,
            'viewport' => $this->viewport
        ], fn ($value) => $value !== null);
    }

    /**
     * Cast to multipart data.
     *
     * @return array
     */
    public function toMultipart()
    {
        return collect($this->toArray())->map(function($value, $key) {
            if($value instanceof Multipartable) {
                return $value->toMultipart();
            }

            return new MultipartData($key, $value);
        })->values()->toArray();
    }

    /**
     * Statically create a new instance.
     *
     * @param string $subject
     * @param string|null $filename
     * @return self
     */
    public static function make(string $subject, ?string $filename = null): static
    {
        return new static($subject, $filename);
    }

}