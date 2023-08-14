<?php

declare(strict_types=1);

namespace App\Scoreboard;

use App\Exception\TeamAlreadyPlayingException;
use App\Game\GameInterface;

final class Scoreboard implements ScoreboardInterface
{
    /**
     * @var GameInterface[]
     */
    private array $games = [];

    public function startGame(GameInterface $game): void
    {
        // Make sure the teams are unique
        foreach ($this->games as $existingGame) {
            if ($existingGame->getHomeTeamName() === $game->getHomeTeamName()
                || $existingGame->getHomeTeamName() === $game->getAwayTeamName()
                || $existingGame->getAwayTeamName() === $game->getHomeTeamName()
                || $existingGame->getAwayTeamName() === $game->getAwayTeamName()
            ) {
                throw new TeamAlreadyPlayingException();
            }
        }

        $game->startGame();

        $this->games[] = $game;
    }

    public function finishGame(GameInterface $game): void
    {
        $index = $this->findGameIndex($game);

        unset($this->games[$index]);
    }

    public function updateScore(GameInterface $game, int $homeTeamScore, int $awayTeamScore): void
    {
        $index = $this->findGameIndex($game);

        $this->games[$index]->updateScore($homeTeamScore, $awayTeamScore);
    }

    public function getGames(): array
    {
        return $this->games;
    }

    /** @infection-ignore-all  */
    public function getSummary(): array
    {
        $sortedGames = $this->games;

        usort($sortedGames, function (GameInterface $gameA, GameInterface $gameB) {
            $totalScoreA = $gameA->getHomeTeamScore() + $gameA->getAwayTeamScore();
            $totalScoreB = $gameB->getHomeTeamScore() + $gameB->getAwayTeamScore();

            if ($totalScoreA == $totalScoreB) {
                return $gameA->getStartTime() <=> $gameB->getStartTime();
            }

            return ($totalScoreA > $totalScoreB) ? -1 : 1;
        });

        return array_map(
            fn(GameInterface $game) => $game->getHomeTeamName() . ' ' . $game->getHomeTeamScore() . ' - '
                . $game->getAwayTeamName() . ' ' . $game->getAwayTeamScore(),
            $sortedGames
        );
    }

    /** @infection-ignore-all  */
    private function findGameIndex(GameInterface $game): int
    {
        $index = array_search($game, $this->games);

        if ($index === false) {
            throw new \InvalidArgumentException('Game not found');
        }

        return $index;
    }
}
