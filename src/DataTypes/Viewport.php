<?php

namespace Actengage\Capture\DataTypes;

use Actengage\Capture\Contracts\Multipartable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Viewport implements Arrayable, Jsonable, Multipartable
{
    /**
     * The `width` of the viewport.
     *
     * @var float
     */
    public int $width;

    /**
     * The `height` of the viewport.
     *
     * @var float
     */
    public int $height;

    /**
     * Create a new instance.
     *
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'width' => $this->width,
            'height' => $this->height
        ];
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Cast to multipart data.
     *
     * @return \Actengage\Capture\DataTypes\MultipartData
     */
    public function toMultipart(): MultipartData
    {
        return new MultipartData('viewport', $this->toJson());
    }
}