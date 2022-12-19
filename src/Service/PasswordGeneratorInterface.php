<?php

namespace App\Service;

interface PasswordGeneratorInterface
{
    public function generate(string $phrase = null): array;

    public function generateWithStrength(string $phrase = null): array;
}