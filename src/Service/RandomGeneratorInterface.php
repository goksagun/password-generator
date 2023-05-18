<?php

namespace App\Service;

interface RandomGeneratorInterface
{
    public function generate(?int $length, ?string $strategy): string;
}