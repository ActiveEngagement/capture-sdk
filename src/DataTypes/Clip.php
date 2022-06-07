<?php

namespace Actengage\Capture\DataTypes;

use Actengage\Capture\Contracts\Multipartable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

class Clip implements Arrayable, Jsonable, Multipartable
{
    /**
     * The `width` of the clip.
     *
     * @var int
     */
    public int $width;

    /**
     * The `height` of the clip.
     *
     * @var int
     */
    public int $height;
    
    /**
     * The `x` coordinate of the clip.
     *
     * @var int
     */
    public int $x;

    /**
     * The `y` coordinate of the clip.
     *
     * @var int
     */
    public int $y;

    /**
     * Create a new instance.
     *
     * @param int $width
     * @param int $height
     * @param int $x
     * @param int $y
     */
    public function __construct(int $width, int $height, int $x = 0, int $y = 0)
    {
        $this->width = $width;
        $this->height = $height;
        $this->x = $x;
        $this->y = $y;
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
            'height' => $this->height,
            'x' => $this->x,
            'y' => $this->y
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
        return new MultipartData('clip', $this->toJson());
    }
}