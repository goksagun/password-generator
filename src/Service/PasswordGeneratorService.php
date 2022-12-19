<?php

namespace App\Service;

use App\Generator\GeneratorInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use ZxcvbnPhp\Zxcvbn;

class PasswordGeneratorService implements PasswordGeneratorInterface
{
    public function __construct(private readonly GeneratorInterface $generator, private readonly CacheInterface $cache)
    {
    }

    public function generate(string $phrase = null): array
    {
        $acronym = $this->cache->get($phrase, function (ItemInterface $item) use ($phrase) {
            return $this->generator->generateFrom($phrase);
        });

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
