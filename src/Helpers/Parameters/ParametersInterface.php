<?php
namespace ScreenshotPages\Helpers\Parameters;

interface ParametersInterface
{
    public function getSaveFolder(): string;

    public function getSaveFormat(): string;
    
    public function getPages(): array;

    public function getViewports(): array;
}