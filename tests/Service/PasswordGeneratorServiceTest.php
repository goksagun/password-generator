<?php

namespace App\Tests\Service;

use App\Service\PasswordGeneratorInterface;
use App\Service\PasswordGeneratorService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class PasswordGeneratorServiceTest extends KernelTestCase
{

    private PasswordGeneratorInterface $passwordGeneratorService;

    protected function setUp(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $this->passwordGeneratorService = $container->get(PasswordGeneratorService::class);
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
        $actual = $this->passwordGeneratorService->generateWithStrength(
            'I go bowling every Friday night with 8 friends'
        );
        $this->assertArrayHasKey('data', $actual);
        $this->assertArrayHasKey('phrase', $actual['data']);
        $this->assertArrayHasKey('acronym', $actual['data']);
        $this->assertArrayHasKey('strength', $actual['data']);
    }
}