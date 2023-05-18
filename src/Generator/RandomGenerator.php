<?php

namespace App\Generator;

use App\Generator\RandomGenerator\AlphaLowerGenerator;
use App\Generator\RandomGenerator\AlphaUpperGenerator;
use App\Generator\RandomGenerator\NumericGenerator;
use App\Generator\RandomGenerator\SpecialGenerator;

class RandomGenerator implements GeneratorInterface
{
    public const STRATEGY_ALPHA_NUMERIC = 0;
    public const STRATEGY_ALPHA = 1;
    public const STRATEGY_NUMERIC = 2;
    public const STRATEGY_COMPLEX = 3;
    public const STRATEGY_ALPHA_LOWER = 4;
    public const STRATEGY_ALPHA_UPPER = 5;
    public const STRATEGY_ALPHANUMERIC_LOWER = 6;
    public const STRATEGY_ALPHANUMERIC_UPPER = 7;

    public const DEFAULT_LENGTH = 8;

    /**
     * @var GeneratorInterface[]
     */
    private iterable $generators;

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
        private readonly int $strategy = self::STRATEGY_ALPHA_NUMERIC
    ) {
        match ($this->strategy) {
            self::STRATEGY_ALPHA => $this->generators = [
                new AlphaLowerGenerator(),
                new AlphaUpperGenerator(),
            ],
            self::STRATEGY_NUMERIC => $this->generators = [
                new NumericGenerator(),
            ],
            self::STRATEGY_ALPHA_NUMERIC => $this->generators = [
                new AlphaLowerGenerator(),
                new AlphaUpperGenerator(),
                new NumericGenerator(),
            ],
            self::STRATEGY_COMPLEX => $this->generators = [
                new AlphaLowerGenerator(),
                new AlphaUpperGenerator(),
                new NumericGenerator(),
                new SpecialGenerator(),
            ],
            self::STRATEGY_ALPHA_LOWER => $this->generators = [
                new AlphaLowerGenerator(),
            ],
            self::STRATEGY_ALPHA_UPPER => $this->generators = [
                new AlphaUpperGenerator(),
            ],
            self::STRATEGY_ALPHANUMERIC_LOWER => $this->generators = [
                new AlphaLowerGenerator(),
                new NumericGenerator(),
            ],
            self::STRATEGY_ALPHANUMERIC_UPPER => $this->generators = [
                new AlphaUpperGenerator(),
                new NumericGenerator(),
            ],
        };
    }


    public function generate(): string
    {
        $result = '';
        for ($i = 0; $i < $this->length; $i++) {
            $generator = $this->getRandomGenerator();

            $result .= $generator->generate();
        }

        return $result;
    }

    private function getRandomGenerator(): mixed
    {
        return $this->generators[array_rand($this->generators)];
    }
}