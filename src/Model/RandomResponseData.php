<?php

namespace App\Model;

class RandomResponseData
{
    public function __construct(
        public ?int $length = null,
        public ?string $random = null,
        public array $strength = [],
    ) {
    }
}