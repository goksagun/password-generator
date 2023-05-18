<?php

namespace App\Tests\Service;

use App\Service\VersionInterface;
use App\Service\VersionService;
use PHPUnit\Framework\TestCase;

class VersionServiceTest extends TestCase
{
    private VersionInterface $versionService;

    protected function setUp(): void
    {
        $this->versionService = new VersionService('tests/Service/Fixtures/VERSION');
    }

    public function testGetVersion()
    {
        $this->assertEquals('0.1.0', $this->versionService->getVersion());
    }
}
