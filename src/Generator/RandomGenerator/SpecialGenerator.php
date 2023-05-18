<?php

namespace App\Generator\RandomGenerator;

class SpecialGenerator extends AbstractRandomGenerator implements \App\Generator\GeneratorInterface
{
    public const CHARACTERS = '][}{@_!#$%^&*()<>?|~:;=-+'; // \]\[}{@_!#$%^&*()<>?|~:;=- -> preg quoted -> \]\[\}\{@_\!\#\$%\^&\*\(\)\<\>\?\|~\:;\=\-

    public function __construct(
        private readonly int $length = self::DEFAULT_LENGTH,
    ) {
    }

    public function generate(): string
    {
        return $this->doRandom($this->length, self::CHARACTERS);
    }
}