<?php

declare(strict_types=1);

namespace App\Scoreboard;

use App\Game\GameInterface;

interface ScoreboardInterface
{
    public function startGame(GameInterface $game): void;

    public function finishGame(GameInterface $game): void;

    public function updateScore(GameInterface $game, int $homeTeamScore, int $awayTeamScore): void;

    /** @return array<GameInterface> */
    public function getGames(): array;

    /** @return array<string> */
    public function getSummary(): array;
}
