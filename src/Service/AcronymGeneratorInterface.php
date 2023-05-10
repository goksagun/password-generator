<?php

namespace App\Service;

interface AcronymGeneratorInterface
{
    public function generate(string $phrase = null): array;

    public function generateWithStrength(string $phrase = null): array;
}