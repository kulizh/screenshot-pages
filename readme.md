# Website Screenshoter
It is server-side PHP-based implementation of Qurle's [Webiste screenshoter library](https://github.com/qurle/screenshot-pages).

## Installation 
Install package via Composer:
```shell
composer require kulizh/screenshot-pages
```

## Configuring
Basically library uses JSON-file params.json that is placed nearby. But you can also use your own implementation of parametrization. 

### Use params.json
While using params.json you shall do nothing but create the file:
```json
{
    "path": "./screenshots",
    "viewports": [
        "1440x900",
        "360x900"
    ],
    "format": "png",
    "pages": [
        "https://kulizh.ru",
        "https://qurle.net"
    ]
}
```

### Use your own config
You can pass your own implementation of `ParametersInterface` in method `useParameters()`. 
```php 
use ScreenshotPages\Helpers\Parameters\ParametersInterface;

class HardcodeParameters implements ParametersInterface
{
    public function getSaveFolder(): string
    {
    	return './result/';
    }

    public function getSaveFormat(): string
    {
    	return 'jpeg';
    }
    
    public function getPages(): array
    {
    	return [
    		'https://www.wikipedia.org/'
    	];
    }

    public function getViewports(): array
    {
    	return [
    		'1920x1080'
    	];
    }
}

$capture = new Capture();
$capture->use(new HardcodeParameters);

```

To make it easier feel free to extend abstract class `AbstractParameters` (that also implements interface), parameters are already preset there:

```php
use ScreenshotPages\Helpers\Parameters\AbstractParameters;

class PresetParameters extends AbstractParameters
{
	
}

$capture = new Capture();
$capture->use(new PresetParameters);
```

## Usage
Create instance of the class and choose how to execute script. If you run it via cli, use `verbose: true` for results to be shown in terminal. Quite mode is good when you use library in your project code.

After all preparations are made, use `make()` method:
```php
use ScreenshotPages\Capture;

$capture = new Capture();
$capture->verbose = true; // To see cli output

$capture->make();
```

## Usage from command line
Since version 1.1.0 you may use library with verbose mode from command line:
```shell
vendor/bin/capture ./params.json
```
... where `./params.json` is relative path to JSON configuration file.
