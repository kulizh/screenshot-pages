<?php
namespace ScreenshotPages;

use HeadlessChromium\Page;
use HeadlessChromium\BrowserFactory;
use HeadlessChromium\Browser\ProcessAwareBrowser;
use ScreenshotPages\Helpers\Cli;
use ScreenshotPages\Helpers\File;
use ScreenshotPages\Helpers\Parameters\ParametersInterface;
use ScreenshotPages\Helpers\Parameters\JSONParameters;

class Capture
{
    public bool $verbose = false;

    private ProcessAwareBrowser $browser;
    private ParametersInterface $parameters;

    public function __construct()
    {
        $this->browser = (new BrowserFactory())->createBrowser();
    }

    public function use(?ParametersInterface $parameters = null): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function __destruct()
    {
        $this->browser->close();
    }

    public function make()
    {
        if (is_null($this->parameters))
        {
            $this->parameters = new JSONParameters('./params.json');
        }

        $this->say('Starting script in verbose mode. Be patient, it will take some time ;)' . PHP_EOL);

        foreach($this->parameters->getPages() as $url)
        {
            $this->say("Preparing $url...");
            $page = $this->browser->createPage();

            foreach($this->parameters->getViewports() as $viewport)
            {
                try
                {
                    $filepath = File::getPath(
                        $this->parameters->getSaveFolder(),
                        $url,
                        $viewport,
                        $this->parameters->getSaveFormat()
                    );
                    $this->say("\tViewport: " . implode('×', $viewport));
                    
                    $page->setViewport($viewport['w'], $viewport['h']);
                    $page->navigate($url)->waitForNavigation(Page::NETWORK_IDLE, 1000000);
                    
                    $this->say("\tSaving to " . $filepath);

                    $page->screenshot()->saveToFile($filepath);
                }
                catch (\Exception $exception)
                {
                    if (!$this->verbose)
                    {
                        throw new \Exception($exception->getMessage());
                    }
                    
                    Cli::error($exception->getMessage());
                }
            }
        }
    }

    private function say(string $message): bool
    {
        if (!$this->verbose)
        {
            return false;
        }

        Cli::info($message);

        return true;
    }
}