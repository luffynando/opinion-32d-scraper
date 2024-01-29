<?php

declare(strict_types=1);

namespace PhpCfdi\Opinion32dScraper;

final readonly class Credentials
{
    public function __construct(private string $rfc, private string $ciec) {}

    public function getRfc(): string
    {
        return $this->rfc;
    }

    public function getCiec(): string
    {
        return $this->ciec;
    }
}
