<?php
namespace ScreenshotPages\Helpers;

final class Cli
{
    public static function info(string $message)
    {
        echo $message . PHP_EOL;
    }

    public static function error(string $message)
    {
        echo "\033[31mError\e[0m " . $message . PHP_EOL;
    }

    public static function success(string $message)
    {
        echo "\033[32mDone\e[0m " . $message . PHP_EOL;
    }
}