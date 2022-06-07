<?php

namespace Actengage\Capture\DataTypes;

use Illuminate\Contracts\Support\Arrayable;

class MultipartData implements Arrayable
{
    /**
     * The name of the multipart data.
     *
     * @var string
     */
    public string $name;

    /**
     * The contents of the multipart data.
     *
     * @var mixed
     */
    public mixed $contents;

    /**
     * The headers of the multipart data.
     *
     * @var array|null
     */
    public ?array $headers = null;

    /**
     * The name of the file.
     *
     * @var string|null
     */
    public ?string $filename = null;

    /**
     * Create an instance.
     *
     * @param string $name
     * @param mixed $contents
     * @param array|null $headers
     * @param string|null $filename
     */
    public function __construct(string $name, mixed $contents, array $headers = null, string $filename = null)
    {
        $this->name = $name;
        $this->contents = is_resource($contents) ? $contents : $this->castString($contents);
        $this->headers = $headers ?? $this->contentTypeHeaders($contents);
        $this->filename = $filename;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return array_filter([
            'name' => $this->name,
            'contents' => $this->contents,
            'headers' => $this->headers,
            'filename' => $this->filename
        ]);
    }

    /**
     * Cast the contents to a string.
     *
     * @param mixed $contents
     * @return string
     */
    protected function castString(mixed $contents): string
    {
        return is_string($contents) ? $contents : json_encode($contents);
    }

    /**
     * Get the content-type header for the contents.
     *
     * @param mixed $contents
     * @return ContentType
     */
    protected function contentType(mixed $contents): ContentType
    {
        if($this->isJson($contents) || !is_string($contents)) {
            return ContentType::JSON;
        }

        return ContentType::Plain;
    }

    /**
     * Get the headers based on the type of contents.
     *
     * @return array|null
     */
    protected function contentTypeHeaders(mixed $contents)
    {
        return ['Content-Type' => $this->contentType($contents)->value];
    }

    /**
     * Checks to see if contents is JSON.
     *
     * @return boolean
     */
    protected function isJson(mixed $contents) {
        return ($json = json_decode($contents)) && $contents != $json;
    }
}