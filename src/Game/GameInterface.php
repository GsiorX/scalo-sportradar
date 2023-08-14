<?php

declare(strict_types=1);

namespace App\Game;

use App\Team\TeamInterface;

interface GameInterface
{
    public function setHomeTeam(TeamInterface $homeTeam): void;

    public function setAwayTeam(TeamInterface $awayTeam): void;

    public function getHomeTeamName(): string;

    public function getAwayTeamName(): string;

    public function getHomeTeamScore(): int;

    public function getAwayTeamScore(): int;

    public function startGame(): void;

    public function getStartTime(): int;

    public function updateScore(int $homeTeamScore, int $awayTeamScore): void;
}
