<?php

namespace App\Service;

use App\Generator\AcronymGenerator;
use ZxcvbnPhp\Zxcvbn;

class AcronymGeneratorService implements AcronymGeneratorInterface
{
    public function __construct()
    {
    }

    public function generate(string $phrase = null): array
    {
        return [
            'data' => [
                'phrase' => $phrase,
                'acronym' => (new AcronymGenerator($phrase))->generate(),
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
