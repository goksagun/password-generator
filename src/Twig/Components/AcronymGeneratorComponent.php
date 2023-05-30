<?php

namespace App\Twig\Components;

use App\Service\AcronymGeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('acronym_generator')]
final class AcronymGeneratorComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $phrase = '';

    public function __construct(private readonly AcronymGeneratorInterface $generator)
    {
    }

    public function getAcronym(): string
    {
        if ('' === $this->phrase) {
            $this->phrase = 'I go bowling every Friday night with 8 friends';
        }

        return $this->generator->generate($this->phrase)['data']['acronym'];
    }
}
