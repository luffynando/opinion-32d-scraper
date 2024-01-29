<?php

declare(strict_types=1);

namespace PhpCfdi\Opinion32dScraper;

use Facebook\WebDriver\WebDriver;
use PhpCfdi\Opinion32dScraper\Contracts\BrowserClientInterface;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use Symfony\Component\Panther\Client;
use Symfony\Component\Panther\Cookie\CookieJar;
use Symfony\Component\Panther\DomCrawler\Crawler;

final readonly class PantherBrowserClient implements BrowserClientInterface
{
    public function __construct(private Client $browserClient) {}

    public function get(string $url): WebDriver
    {
        return $this->browserClient->get($url);
    }

    public function waitFor(string $locator, int $timeoutInSecond = 30, int $intervalInMillisecond = 250): Crawler
    {
        return $this->browserClient->waitFor($locator, $timeoutInSecond, $intervalInMillisecond);
    }

    public function getCrawler(): Crawler
    {
        return $this->browserClient->getCrawler();
    }

    public function submit(Form $form, array $values = [], array $serverParameters = []): DomCrawler
    {
        return $this->browserClient->submit($form, $values, $serverParameters);
    }

    public function getCookieJar(): CookieJar
    {
        return $this->browserClient->getCookieJar();
    }
}
