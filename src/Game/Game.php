<?php

declare(strict_types=1);

namespace App\Game;

use App\Team\Team;

final class Game implements GameInterface
{
    public function __construct(
        private readonly Team $homeTeam,
        private readonly Team $awayTeam,
        private int $homeTeamScore = 0,
        private int $awayTeamScore = 0
    ) {
    }

    public function getHomeTeamName(): string
    {
        return $this->homeTeam->getName();
    }

    public function getAwayTeamName(): string
    {
        return $this->awayTeam->getName();
    }

    public function getHomeTeamScore(): int
    {
        return $this->homeTeamScore;
    }

    public function getAwayTeamScore(): int
    {
        return $this->awayTeamScore;
    }

    public function updateScore(int $homeTeamScore, int $awayTeamScore): void
    {
        $this->homeTeamScore = $homeTeamScore;
        $this->awayTeamScore = $awayTeamScore;
    }
}