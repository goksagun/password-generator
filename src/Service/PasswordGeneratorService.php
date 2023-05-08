<?php

namespace App\Service;

use App\Generator\AcronymGenerator;
use Symfony\Contracts\Cache\CacheInterface;
use ZxcvbnPhp\Zxcvbn;

class PasswordGeneratorService implements PasswordGeneratorInterface
{
    public function __construct(private readonly CacheInterface $cache)
    {
    }

    public function generate(string $phrase = null): array
    {
        return [
            'data' => [
                'phrase' => $phrase,
                'acronym' => $this->cache->get($phrase, function () use ($phrase): string {
                    return (new AcronymGenerator($phrase))->generate();
                }),
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
