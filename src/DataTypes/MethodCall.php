<?php

namespace Actengage\Capture\DataTypes;

use Illuminate\Contracts\Support\Arrayable;

class MethodCall implements Arrayable
{
    /**
     * The method name.
     *
     * @var string
     */
    public string $method;

    /**
     * The arguments passed to the method.
     *
     * @var array
     */
    public array $args;

    /**
     * Create an instance.
     *
     * @param string $method
     * @param array $args
     */
    public function __construct(string $method, array $args)
    {
        $this->method = $method;
        $this->args = $args;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [$this->method, $this->args];
    }
}