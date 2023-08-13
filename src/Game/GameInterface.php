<?php

namespace App\Game;

interface GameInterface
{
    public function getHomeTeamName(): string;

    public function getAwayTeamName(): string;

    public function getHomeTeamScore(): int;

    public function getAwayTeamScore(): int;

    public function updateScore(int $homeTeamScore, int $awayTeamScore): void;
}