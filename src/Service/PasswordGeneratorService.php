<?php

namespace App\Service;

use App\Generator\GeneratorInterface;
use ZxcvbnPhp\Zxcvbn;

class PasswordGeneratorService
{
    public function __construct(private readonly GeneratorInterface $generator)
    {
    }

    public function generate(?string $phrase = null): array
    {
        if (null === $phrase) {
            $acronym = $this->generator->generate();
        } else {
            $acronym = $this->generator->generateFrom($phrase);
        }

        $zxcvbn = new Zxcvbn();

        return [
            'data' => [
                'phrase' => $phrase,
                'acronym' => $acronym,
                'strength' => $zxcvbn->passwordStrength($acronym),
                'created' => (new \DateTimeImmutable())->format(DATE_ATOM),
            ],
        ];
    }
}