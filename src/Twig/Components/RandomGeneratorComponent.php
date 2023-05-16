<?php

namespace App\Twig\Components;

use App\Generator\RandomGenerator;
use App\Service\RandomGeneratorInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('random_generator')]
final class RandomGeneratorComponent implements LoggerAwareInterface
{
    use LoggerAwareTrait;
    use DefaultActionTrait;

    private const MAX_LENGTH = 64;

    #[LiveProp(writable: true)]
    public int $length = RandomGenerator::DEFAULT_LENGTH;
    #[LiveProp(writable: true)]
    public int $strategy = RandomGenerator::STRATEGY_ALPHA_NUMERIC;

    public function __construct(private readonly RandomGeneratorInterface $generator)
    {
    }

    public function getRandom(): string
    {
        if ($this->length > self::MAX_LENGTH) {
            $this->length = self::MAX_LENGTH;
        }

        return $this->generator->generate($this->length, $this->strategy);
    }
}
