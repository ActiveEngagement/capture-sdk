<?php

namespace Actengage\Capture\DataTypes;

use Actengage\Capture\Contracts\Multipartable;
use Illuminate\Contracts\Support\Arrayable;

class Subject implements Arrayable, Multipartable
{
    /**
     * The html used to take screenshot.
     *
     * @var string|null
     */
    public ?string $html = null;
    
    /**
     * The url used to take screenshot.
     *
     * @var string|null
     */
    public ?string $url = null;

    /**
     * The name of the file.
     *
     * @var string|null
     */
    public ?string $filename = null;

    /**
     * Create a new instance.
     *
     * @param mixed $subject
     */
    public function __construct(mixed $subject, string $filename = null)
    {
        if(filter_var($subject, FILTER_VALIDATE_URL)) {
            $this->url = $subject;
        }
        else {
            $this->html = $subject;
        }

        $this->filename = $filename;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'url' => $this->url,
            'html' => $this->html
        ];
    }

    /**
     * Cast to multipart data.
     *
     * @return \Actengage\Capture\DataTypes\MultipartData
     */
    public function toMultipart(): MultipartData
    {
        return $this->html
            ? $this->toHtmlMultipartData()
            : $this->toUrlMultipartData();
    }
    
    /**
     * Cast html to multipart data.
     *
     * @return \Actengage\Capture\DataTypes\MultipartData
     */
    protected function toHtmlMultipartData(): MultipartData
    {
        $stream = fopen('php://memory', 'r+');

        fwrite($stream, $this->html);
        rewind($stream);

        return new MultipartData('html', $stream, [
            'Content-Type' => 'application/octet-stream',
        ], $this->filename ?? sprintf('%s.html', md5(microtime())));
    }
    
    /**
     * Cast url to multipart data.
     *
     * @return \Actengage\Capture\DataTypes\MultipartData
     */
    protected function toUrlMultipartData(): MultipartData
    {
        return new MultipartData('url', $this->url);
    }
}