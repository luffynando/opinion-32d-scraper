<?php

declare(strict_types=1);

namespace PhpCfdi\Opinion32dScraper\Contracts;

use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeoutException;
use Facebook\WebDriver\WebDriver;
use Symfony\Component\DomCrawler\Form;
use Symfony\Component\Panther\Cookie\CookieJar;
use Symfony\Component\Panther\DomCrawler\Crawler;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;

interface BrowserClientInterface
{
    public function get(string $url): WebDriver;

    /**
     * @throws TimeoutException
     * @throws NoSuchElementException
     */
    public function waitFor(string $locator, int $timeoutInSecond = 30, int $intervalInMillisecond = 250): Crawler;

    public function getCrawler(): Crawler;

    /**
     * @param array<string, mixed> $values
     * @param array<string, mixed> $serverParameters
     */
    public function submit(Form $form, array $values = [], array $serverParameters = []): DomCrawler;

    public function getCookieJar(): CookieJar;
}
