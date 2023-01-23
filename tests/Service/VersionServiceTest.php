<?php

namespace App\Tests\Service;

use App\Service\VersionService;
use PHPUnit\Framework\TestCase;

class VersionServiceTest extends TestCase
{

    public function testGetVersion()
    {
        $this->assertEquals('0.1.0', (new VersionService('tests/Service/Fixtures/VERSION'))->getVersion());
    }
}
