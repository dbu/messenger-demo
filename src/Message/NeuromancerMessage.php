<?php

declare(strict_types=1);

namespace App\Message;

final readonly class NeuromancerMessage
{
    public function __construct(
        private string $text)
    {
    }

    public function getText(): string
    {
        return $this->text;
    }
}
