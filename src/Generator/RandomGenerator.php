<?php

namespace App\Generator;

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

    public const NUMERIC_CHARACTERS = '0123456789'; // [0-9]
    public const ALPHA_LOWER_CHARACTERS = 'abcdefghijklmnopqrstuvwxyz'; // [a-z]
    public const ALPHA_UPPER_CHARACTERS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // [A-Z]
    public const ALPHA_CHARACTERS = self::ALPHA_LOWER_CHARACTERS . self::ALPHA_UPPER_CHARACTERS;
    public const SPECIAL_CHARACTERS = '][}{@_!#$%^&*()<>?|~:;=-+'; // \]\[}{@_!#$%^&*()<>?|~:;=- -> preg quoted -> \]\[\}\{@_\!\#\$%\^&\*\(\)\<\>\?\|~\:;\=\-
    public const SPECIAL_CHARACTERS_REGEX = '\]\[\}\{\|\@\_\!\#\$\%\^\&\*\(\)\<\>\?\~\:\;\=\-\+';

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
        private readonly int $strategy = self::STRATEGY_ALPHA_NUMERIC
    ) {
    }

    public function generate(): string
    {
        return match ($this->strategy) {
            self::STRATEGY_ALPHA => $this->alpha($this->length),
            self::STRATEGY_NUMERIC => $this->numeric($this->length),
            self::STRATEGY_ALPHA_NUMERIC => $this->alnum($this->length),
            self::STRATEGY_COMPLEX => $this->complex($this->length),
            self::STRATEGY_ALPHA_LOWER => $this->alphaLower($this->length),
            self::STRATEGY_ALPHA_UPPER => $this->alphaUpper($this->length),
            self::STRATEGY_ALPHANUMERIC_LOWER => $this->alnumLower($this->length),
            self::STRATEGY_ALPHANUMERIC_UPPER => $this->alnumUpper($this->length),
        };
    }

    public function alpha($length): string
    {
        return $this->doRandom($length, self::ALPHA_CHARACTERS);
    }

    public function numeric($length): string
    {
        return $this->doRandom($length, self::NUMERIC_CHARACTERS);
    }

    public function alnum($length): string
    {
        return $this->doRandom($length, self::ALPHA_CHARACTERS . self::NUMERIC_CHARACTERS);
    }

    public function complex(int $length): string
    {
        return $this->doRandom($length, self::ALPHA_CHARACTERS . self::NUMERIC_CHARACTERS . self::SPECIAL_CHARACTERS);
    }

    public function alphaLower(int $length): string
    {
        return $this->doRandom($length, self::ALPHA_LOWER_CHARACTERS);
    }

    public function alphaUpper(int $length): string
    {
        return $this->doRandom($length, self::ALPHA_UPPER_CHARACTERS);
    }

    public function alnumLower(int $length): string
    {
        return $this->doRandom($length, self::ALPHA_LOWER_CHARACTERS . self::NUMERIC_CHARACTERS);
    }

    public function alnumUpper(int $length): string
    {
        return $this->doRandom($length, self::ALPHA_UPPER_CHARACTERS . self::NUMERIC_CHARACTERS);
    }

    private function doRandom(int $length, string $chars): string
    {
        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, $max)];
        }

        return $result;
    }
}