<?php

namespace App\Generator;

class RandomGenerator implements GeneratorInterface
{
    public const STRATEGY_ALPHA_NUMERIC = 0;
    public const STRATEGY_ALPHA = 1;
    public const STRATEGY_NUMERIC = 2;
    public const STRATEGY_COMPLEX = 3;

    public const DEFAULT_LENGTH = 8;

    private const ALPHA_CHARACTERS = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const NUMERIC_CHARACTERS = '0123456789';
    private const SPECIAL_CHARACTERS = '[@_!#$%^&*()<>?/|}{~:]';

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
        private readonly int $strategy = self::STRATEGY_ALPHA_NUMERIC
    ) {
    }

    public function generate(): string
    {
        return match ($this->strategy) {
            self::STRATEGY_COMPLEX => $this->complex($this->length),
            self::STRATEGY_ALPHA_NUMERIC => $this->alnum($this->length),
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
        $characters = self::NUMERIC_CHARACTERS;
        $result = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, $max)];
        }

        return $result;
    }

    public function alnum($length): string
    {
        $characters = self::ALPHA_CHARACTERS . self::NUMERIC_CHARACTERS;
        $result = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, $max)];
        }

        return $result;
    }

    public function complex(int $length): string
    {
        $characters = self::ALPHA_CHARACTERS . self::NUMERIC_CHARACTERS . self::SPECIAL_CHARACTERS;
        $result = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $characters[random_int(0, $max)];
        }

        return $result;
    }
}