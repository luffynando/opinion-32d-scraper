<?php

declare(strict_types=1);

namespace PhpCfdi\Opinion32dScraper;

use GuzzleHttp\Cookie\CookieJar as GuzzleCookieJar;
use GuzzleHttp\Cookie\CookieJarInterface;
use GuzzleHttp\Cookie\SetCookie;

final readonly class CookieParser
{
    public function __construct(private \Symfony\Component\BrowserKit\CookieJar $browserCookieJar) {}

    public function guzzleCookieJar(): CookieJarInterface
    {
        $cookieJar = new GuzzleCookieJar();
        foreach ($this->browserCookieJar->all() as $cookie) {
            $cookieJar->setCookie(
                new SetCookie([
                    'Name' => $cookie->getName(),
                    'Value' => $cookie->getValue(),
                    'Domain' => $cookie->getDomain(),
                ])
            );
        }

        return $cookieJar;
    }
}
