<?php

namespace App\Model;

class RandomResponse
{
    public function __construct(
        public ?RandomResponseData $data = null
    ) {
    }
}