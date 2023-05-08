<?php

namespace App\Generator;

class RandomGenerator implements GeneratorInterface
{
    public const STRATEGY_ALPHA_NUMERIC = 0;
    public const STRATEGY_ALPHA = 1;
    public const STRATEGY_NUMERIC = 2;

    public const DEFAULT_LENGTH = 8;
    private const ALPHA_NUMERIC_CHARACTERS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const ALPHA_CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
        private readonly int $strategy = self::STRATEGY_ALPHA_NUMERIC
    ) {
    }

    public function generate(): string
    {
        return match ($this->strategy) {
            self::STRATEGY_ALPHA_NUMERIC => $this->alphaNumeric($this->length),
            self::STRATEGY_ALPHA => $this->alpha($this->length),
            self::STRATEGY_NUMERIC => $this->numeric($this->length),
        };
    }

    public function alpha($length): string
    {
        $characters = self::ALPHA_CHARACTERS;
        $result = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, $max)];
        }

        return $result;
    }

    public function numeric($length): string
    {
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= random_int(0, 9);
        }

        return $result;
    }

    public function alphaNumeric($length): string
    {
        $characters = self::ALPHA_NUMERIC_CHARACTERS;
        $result = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, $max)];
        }

        return $result;
    }
}