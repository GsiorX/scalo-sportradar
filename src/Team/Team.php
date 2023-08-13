<?php

declare(strict_types=1);

namespace App\Team;

final class Team implements TeamInterface
{
    public function __construct(private readonly string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
