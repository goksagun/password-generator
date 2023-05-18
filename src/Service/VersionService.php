<?php

namespace App\Service;

use App\Utils\StringUtils;

class VersionService implements VersionInterface
{
    public function __construct(private readonly string $versionFile)
    {
    }

    public function getVersion(): string
    {
        return StringUtils::removeLineFeed(file_get_contents($this->versionFile));
    }
}