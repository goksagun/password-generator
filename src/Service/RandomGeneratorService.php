<?php

namespace App\Service;

use App\Generator\RandomGenerator;

class RandomGeneratorService implements RandomGeneratorInterface
{

    public function generate(?int $length, ?string $strategy): string
    {
        $length = $length ?? RandomGenerator::DEFAULT_LENGTH;
        $strategy = $strategy ?? RandomGenerator::STRATEGY_ALPHA_NUMERIC;

        return (new RandomGenerator($length, $strategy))->generate();
    }
}