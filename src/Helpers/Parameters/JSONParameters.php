<?php
namespace ScreenshotPages\Helpers\Parameters;

class JSONParameters extends AbstractParameters
{
    public function __construct(string $filename)
    {
        $this->readFromFile($filename);
    }

    private function readFromFile(string $filename): self
    {
        if (!is_readable($filename))
        {
            throw new \Exception($filename . ' is not readable');
        }

        $contents = file_get_contents($filename);
        $contents = json_decode($contents, true);

        if (empty($contents))
        {
            throw new \Exception($filename . ' is not JSON or is empty');
        }

        $this->setValues($contents);
        
        return $this;
    }

    private function setValues(array $contents)
    {
        if (empty($contents['pages']))
        {
            throw new \Exception('Empty `pages` field');
        }

        $this->setSaveFolder($contents['path']);
        $this->setSaveFormat($contents['format'] ?? $this->saveFormat);
        $this->setPages($contents['pages']);
        $this->setViewports($contents['viewports'] ?? $this->viewports);
    }
}