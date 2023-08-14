<?php

namespace AppTests\Unit;

use App\Game\Game;
use App\Scoreboard\Scoreboard;
use App\Team\Team;
use PHPUnit\Framework\TestCase;

/** @covers \App\Scoreboard\Scoreboard*/
final class ScoreboardTest extends TestCase
{
    public function testStartGame(): void
    {
        // Given I have a scoreboard
        $scoreboard = new Scoreboard();

        // And I have two teams
        $homeTeam = new Team();
        $homeTeam->setName('Home Team');
        $awayTeam = new Team();
        $awayTeam->setName('Away Team');

        // And I have a game
        $game = new Game();
        $game->setHomeTeam($homeTeam);
        $game->setAwayTeam($awayTeam);

        // When I start a game
        $scoreboard->startGame($game);

        // Then I expect the game to be in the list of games
        $this->assertCount(1, $scoreboard->getGames());
    }

    public function testFinishGame(): void
    {
        // Given I have a scoreboard
        $scoreboard = new Scoreboard();

        // And I have two teams
        $homeTeam = new Team();
        $homeTeam->setName('Home Team');
        $awayTeam = new Team();
        $awayTeam->setName('Away Team');

        // And I have a game
        $game = new Game();
        $game->setHomeTeam($homeTeam);
        $game->setAwayTeam($awayTeam);

        // And I have started a game
        $scoreboard->startGame($game);

        // When I finish the game
        $scoreboard->finishGame($game);

        // Then I expect the game to not be in the list of games
        $this->assertCount(0, $scoreboard->getGames());
    }
}
