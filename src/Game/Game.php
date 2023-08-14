<?php

declare(strict_types=1);

namespace App\Game;

use App\Exception\NegativeScoreException;
use App\Exception\NonUniqueTeamNameException;
use App\Exception\StartGameException;
use App\Team\TeamInterface;

final class Game implements GameInterface
{
    private TeamInterface $homeTeam;
    private TeamInterface $awayTeam;
    private int $startTime;
    private int $homeTeamScore = 0;
    private int $awayTeamScore = 0;

    public function setHomeTeam(TeamInterface $homeTeam): void
    {
        if (isset($this->awayTeam) && $homeTeam->getName() === $this->awayTeam->getName()) {
            throw new NonUniqueTeamNameException();
        }

        $this->homeTeam = $homeTeam;
    }

    public function setAwayTeam(TeamInterface $awayTeam): void
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

    public function startGame(): void
    {
        // Make sure the team names are set and the scores are 0
        if (!isset($this->homeTeam, $this->awayTeam)) {
            throw new StartGameException();
        }

        if ($this->homeTeamScore !== 0 || $this->awayTeamScore !== 0) {
            throw new StartGameException();
        }

        $this->startTime = (new \DateTimeImmutable())->getTimestamp();
    }

    public function setStartTime(int $timestamp): void
    {
        $this->startTime = $timestamp;
    }

    public function getStartTime(): int
    {
        return $this->startTime;
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
