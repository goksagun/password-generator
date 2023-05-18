<?php

namespace App\Twig\Runtime;

use App\Service\VersionInterface;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private readonly VersionInterface $versionService)
    {
    }

    public function getAppVersion(): string
    {
        return $this->versionService->getVersion();
    }
}
