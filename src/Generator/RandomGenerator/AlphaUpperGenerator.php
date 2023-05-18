<?php

namespace App\Generator\RandomGenerator;

use App\Generator\GeneratorInterface;

class AlphaUpperGenerator extends AbstractRandomGenerator implements GeneratorInterface
{
    public const CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // [A-Z]

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
    ) {
    }

    public function generate(): string
    {
        return $this->doRandom($this->length, self::CHARACTERS);
    }
}