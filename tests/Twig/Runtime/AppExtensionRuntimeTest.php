<?php

namespace App\Tests\Twig\Runtime;

use App\Twig\Runtime\AppExtensionRuntime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AppExtensionRuntimeTest extends KernelTestCase
{
    private null|object $appExtensionRuntime;

    protected function setUp(): void
    {
        $this->appExtensionRuntime = static::getContainer()->get(AppExtensionRuntime::class);
    }


    public function testGetAppVersion()
    {
        $appVersion = $this->appExtensionRuntime->getAppVersion();

        $this->assertEquals('0.1.0', $appVersion);
    }
}
