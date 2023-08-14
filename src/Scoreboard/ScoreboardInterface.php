<?php

namespace App\Scoreboard;

use App\Game\Game;

interface ScoreboardInterface
{
    public function startGame(Game $game): void;

    public function finishGame(Game $game): void;

    public function getGames(): array;

    public function getSummary(): array;
}