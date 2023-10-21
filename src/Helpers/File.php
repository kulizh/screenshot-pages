<?php
namespace ScreenshotPages\Helpers;

final class File
{
    public static function getPath(string $rootpath, string $url, array $viewport, string $format): string
    {
        $filepath = $rootpath . '/'. parse_url($url, PHP_URL_HOST);
        $filepath .= '/' . implode('_', $viewport);

        self::check($rootpath);

        $filepath .= '.' . $format;

        return $filepath;
    }

    private static function check($path)
    {
        if (!is_dir($path))
        {
            self::create($path);
        }
    }

    private static function create(string $path)
    {
        if (!mkdir($path, 0777, true))
        {
            throw new \Exception('Could not create ' . $path);
        }
    }
}