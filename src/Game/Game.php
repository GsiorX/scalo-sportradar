<?php

declare(strict_types=1);

namespace App\Game;

use App\Exception\NegativeScoreException;
use App\Exception\NonUniqueTeamNameException;
use App\Team\Team;

final class Game implements GameInterface
{
    private Team $homeTeam;
    private Team $awayTeam;
    private int $homeTeamScore = 0;
    private int $awayTeamScore = 0;

    public function setHomeTeam(Team $homeTeam): void
    {
        if (isset($this->awayTeam) && $homeTeam->getName() === $this->awayTeam->getName()) {
            throw new NonUniqueTeamNameException();
        }

        $this->homeTeam = $homeTeam;
    }

    public function setAwayTeam(Team $awayTeam): void
    {
        if (isset($this->homeTeam) && $awayTeam->getName() === $this->homeTeam->getName()) {
            throw new NonUniqueTeamNameException();
        }

        $this->awayTeam = $awayTeam;
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
        if ($homeTeamScore < 0 || $awayTeamScore < 0) {
            throw new NegativeScoreException();
        }

        $this->homeTeamScore = $homeTeamScore;
        $this->awayTeamScore = $awayTeamScore;
    }
}