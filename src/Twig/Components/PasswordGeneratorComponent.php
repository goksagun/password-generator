<?php

namespace App\Twig\Components;

use App\Generator\GeneratorInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('password_generator')]
final class PasswordGeneratorComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $phrase = '';

    public function __construct(private readonly GeneratorInterface $generator)
    {
    }

    public function getPassword(): string
    {
        if ('' === $this->phrase) {
            return $this->generator->generateFrom('I go bowling every Friday night with 8 friends');
        }

        return $this->generator->generateFrom($this->phrase);
    }
}
