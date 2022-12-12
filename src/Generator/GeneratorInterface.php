<?php

namespace App\Generator;

interface GeneratorInterface
{
    public function generateFrom(string $phrase): string;
}