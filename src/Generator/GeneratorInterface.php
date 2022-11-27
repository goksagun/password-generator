<?php

namespace App\Generator;

interface GeneratorInterface
{
    public function generate(): string;

    public function generateFrom(string $phrase): string;
}