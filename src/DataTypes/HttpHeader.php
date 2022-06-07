<?php

namespace Actengage\Capture\DataTypes;

use Illuminate\Contracts\Support\Arrayable;

class HttpHeader implements Arrayable
{
    /**
     * The key of the header.
     *
     * @var string
     */
    public string $key;

    /**
     * The value of the header.
     *
     * @var string
     */
    public string $value;

    /**
     * Create an instance.
     *
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'key' => $this->key,
            'value' => $this->value
        ];
    }
}