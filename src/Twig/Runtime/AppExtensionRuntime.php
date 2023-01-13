<?php

namespace App\Twig\Runtime;

use App\Utils\StringUtils;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private readonly string $versionFile)
    {
    }

    public function getAppVersion(): string
    {
        return StringUtils::removeLineFeed(file_get_contents($this->versionFile));
    }
}
