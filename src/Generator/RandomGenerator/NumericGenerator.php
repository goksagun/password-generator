<?php

namespace App\Generator\RandomGenerator;

use App\Generator\GeneratorInterface;

class NumericGenerator extends AbstractRandomGenerator implements GeneratorInterface
{
    public const CHARACTERS = '0123456789'; // [0-9]

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
    ) {
    }

    public function generate(): string
    {
        return $this->doRandom($this->length, self::CHARACTERS);
    }
}