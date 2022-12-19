<?php

namespace App\Twig\Components;

use App\Service\PasswordGeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('password_generator')]
final class PasswordGeneratorComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $phrase = '';

    public function __construct(private readonly PasswordGeneratorInterface $generator)
    {
    }

    public function getPassword(): string
    {
        if ('' === $this->phrase) {
            $this->phrase = 'I go bowling every Friday night with 8 friends';
        }

        return $this->generator->generate($this->phrase)['data']['acronym'];
    }
}
