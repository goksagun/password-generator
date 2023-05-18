<?php

namespace App\Generator\RandomGenerator;

use App\Generator\GeneratorInterface;

class AlphaLowerGenerator extends AbstractRandomGenerator implements GeneratorInterface
{
    public const CHARACTERS = 'abcdefghijklmnopqrstuvwxyz'; // [a-z]

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
    ) {
    }

    public function generate(): string
    {
        return $this->doRandom($this->length, self::CHARACTERS);
    }
}