<?php
namespace ScreenshotPages\Helpers\Parameters;

abstract class AbstractParameters implements ParametersInterface
{
    protected string $saveFolder = './screenshots/';
    protected string $saveFormat = 'png';

    protected array $pages = [];
    protected array $viewports = [
        '1440x900',
        '360x900'
    ];

    public function setSaveFolder(string $path): self
    {
        $this->saveFolder = $path;

        return $this;
    }

    public function setSaveFormat(string $format): self
    {
        $this->saveFormat = $format;

        return $this;
    }
    
    public function setPages(array $pages): self
    {
        $this->pages = $pages;
        
        return $this;
    }

    public function setViewports(array $viewports): self
    {
        $this->viewports = $this->parseViewports($viewports);

        return $this;
    }

    public function getSaveFolder(): string
    {
        return $this->saveFolder;
    }

    public function getSaveFormat(): string
    {
        return $this->saveFormat;
    }
    
    public function getPages(): array
    {
        return $this->pages;
    }

    public function getViewports(): array
    {
        return $this->viewports;
    }

    private function parseViewports(array $viewports): array
    {
        $result = [];

        foreach($viewports as $item)
        {
            $item = explode('x', $item);

            $result[] = [
                'w' => $item[0],
                'h' => $item[1],
            ];
        }

        return $result;
    }
}