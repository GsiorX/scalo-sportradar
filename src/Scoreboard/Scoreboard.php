<?php

namespace App\Scoreboard;

use App\Game\Game;

class Scoreboard implements ScoreboardInterface
{
    private array $games = [];

    public function startGame(Game $game): void
    {
        // TODO: Implement startGame() method.
    }

    public function finishGame(Game $game): void
    {
        // TODO: Implement finishGame() method.
    }

    public function updateScore(Game $game, int $homeTeamScore, int $awayTeamScore): void
    {
        // TODO: Implement updateScore() method.
    }

    public function getGames(): array
    {
        // TODO: Implement getGames() method.
    }

    public function getSummary(): array
    {
        // TODO: Implement getSummary() method.
    }
}