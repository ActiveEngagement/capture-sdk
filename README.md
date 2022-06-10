# Capture SDK

This package provides fluent SDK for the Capture server. Capture is a Node server on AWS that takes screenshots with a variety of options. This package requires access to a Capture server endpoint before it be used.

## Requirements

- Laravel ^9.1
- PHP ^8.1
- Guzzle ^7.0
- Capture Server Endpoint

## Capture Server

Why is the Capture server endpoint not included in the package? Capture is a private Node server that runs Puppeteer with a specific set of features that are used for our internal products. We do not publish the URL, as its not intended for public consumption. You may however deploy your own Capture server and endpoint.

[Capture Server](https://github.com/ActiveEngagement/capture)

## Installation

*Install via Composer*
 
```php
composer require actengage/capture-sdk
```

*Publish the config file*

```php
php artisan vendor:publish --tag=capture-config
```

*Set the endpoint URL in your ENV file.*

```php
CAPTURE_ENDPOINT=http://localhost:3000/
```

## Basic Usage

```php
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')->request();
```

### Calls

Call allow you to execute methods on the Puppeteer `page` instance before the screenshot has been taken. This is a convenient way to execute a sequence of actions that are explicitly built into the server options (mainly for edge cases). The first argument is the method name, and all other arguments are passed to the method in Puppeteer.

```php
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->call('$', 'header#nav > .logo')
    ->request();
```

### Clipping

Clip a portion of an image using `width`, `height`, `x`, and `y` coordinates. There is no clipping by default.

```php
use Actengage\Capture\DataTypes\Clip;
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->clip(new Clip(800, 600, 400, 300))
    ->request();
```

### Encoding

Encoding changes how the response is composed, either using `binary` or `base64`. Defaults to `binary`.

```php
use Actengage\Capture\DataTypes\Encoding;
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->encoding(Encoding::Binary)
    ->request();
```

### Full Page

Take full page screenshots. Defaults to `false`.

```php
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->fullPage(true)
    ->request();
```

### Headers

Pass a custom headers that are included by Puppeteer in its HTTP request. Defaults to `{"Accept-Language": "en-US"}`.

```php
use Actengage\Capture\DataTypes\Encoding;
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->header('Accept-Language', 'en-US')
    ->request();
```

### Omit Background

This omits the black background for transparent PNG images. Defaults to `true`.

```php
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->omitBackground(true)
    ->request();
```

### Quality

The quality of image that is returned. Must be `1-100`. Defaults to `100`.

```php
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->quality(100)
    ->request();
```

### Timeout

The timeout of the Puppeteer request (in milliseconds). Defaults to `25000`.

```php
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->timeout(15000)
    ->request();
```

### Type

The type of image that is returned, `jpeg` or `png`. Defaults to `jpeg`.

```php
use Actengage\Capture\DataTypes\Type;
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->type(Type::PNG)
    ->request();
```

### Viewport

The viewport dimensions. Defaults to `{"width": 1200, "height": 800}`.

```php
use Actengage\Capture\DataTypes\Viewport;
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->viewport(new Viewport(1200, 800))
    ->request();
```

### Wait Until

How long should Puppeteer wait before returning a response. Defaults to `['load', 'networkidle2']`.

```php
use Actengage\Capture\DataTypes\WaitUntil;
use Actengage\Capture\Facades\Screenshot;

$response = Screenshot::make('https://google.com')
    ->waitUntil([WaitUntil::Load, WaitUntil::NetworkIdle2])
    ->request();
```