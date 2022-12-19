<?php

namespace App\Service;

use App\Generator\GeneratorInterface;
use ZxcvbnPhp\Zxcvbn;

class PasswordGeneratorService
{
    public function __construct(private readonly GeneratorInterface $generator)
    {
    }

    public function generate(string $phrase = null): array
    {
        $acronym = $this->generator->generateFrom($phrase);

        return [
            'data' => [
                'phrase' => $phrase,
                'acronym' => $acronym,
            ],
        ];
    }

    public function generateWithStrength(string $phrase = null): array
    {
        $result = $this->generate($phrase);

        $result['data']['strength'] = (new Zxcvbn())->passwordStrength($result['data']['acronym']);

        return $result;
    }
}
