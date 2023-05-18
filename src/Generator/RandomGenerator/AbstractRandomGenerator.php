<?php

namespace App\Generator\RandomGenerator;

abstract class AbstractRandomGenerator
{
    public const DEFAULT_LENGTH = 1;

    protected function doRandom(int $length, string $chars): string
    {
        $result = '';
        $max = strlen($chars) - 1;
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, $max)];
        }

        return $result;
    }
}