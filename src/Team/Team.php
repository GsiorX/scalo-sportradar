<?php

declare(strict_types=1);

namespace App\Team;

use App\Exception\BadTeamNameException;

final class Team implements TeamInterface
{
    private string $name;

    public function setName(string $name): void
    {
        if (empty(trim($name))) {
            throw new BadTeamNameException();
        }

        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
