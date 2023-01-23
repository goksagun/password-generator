<?php

namespace App\Twig\Runtime;

use App\Service\VersionService;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct(private readonly VersionService $versionService)
    {
    }

    public function getAppVersion(): string
    {
        return $this->versionService->getVersion();
    }
}
