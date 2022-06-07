<?php

namespace Actengage\Capture\Facades;

use Actengage\Capture\ScreenshotFactory;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Actengage\Capture\ScreenshotFactory
 */
class Screenshot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ScreenshotFactory::class;
    }
}