<?php

namespace App\Tests\Service;

use App\Generator\PasswordGenerator;
use App\Service\PasswordGeneratorService;
use PHPUnit\Framework\TestCase;

class PasswordGeneratorServiceTest extends TestCase
{

    private PasswordGeneratorService $passwordGeneratorService;

    protected function setUp(): void
    {
        $this->passwordGeneratorService = new PasswordGeneratorService(new PasswordGenerator());
    }

    public function testGenerate()
    {
        $actual = $this->passwordGeneratorService->generate('I go bowling every Friday night with 8 friends');
        $this->assertArrayHasKey('data', $actual);
        $this->assertArrayHasKey('phrase', $actual['data']);
        $this->assertArrayHasKey('acronym', $actual['data']);
    }

    public function testGenerateWithStrength()
    {
        $actual = $this->passwordGeneratorService->generateWithStrength('I go bowling every Friday night with 8 friends');
        $this->assertArrayHasKey('data', $actual);
        $this->assertArrayHasKey('phrase', $actual['data']);
        $this->assertArrayHasKey('acronym', $actual['data']);
        $this->assertArrayHasKey('strength', $actual['data']);
    }
}
