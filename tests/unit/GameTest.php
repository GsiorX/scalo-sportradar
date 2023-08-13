<?php

declare(strict_types=1);

namespace AppTests\Unit;

use App\Game\Game;
use App\Team\Team;
use PHPUnit\Framework\TestCase;

/** @covers \App\Game\Game */
final class GameTest extends TestCase
{
    public function testGetTeamNames(): void
    {
        // Given I have a game with two teams
        $game = new Game(
            new Team('Team 1'),
            new Team('Team 2')
        );

        // When I get the names of the teams
        $homeTeamName = $game->getHomeTeamName();
        $awayTeamName = $game->getAwayTeamName();

        // Then I expect the home team to be 'Team 1'
        $this->assertSame('Team 1', $homeTeamName);
        // And I expect the away team to be 'Team 2'
        $this->assertSame('Team 2', $awayTeamName);
    }

    public function testGetInitialScore(): void
    {
        // Given I have a game with two teams
        $game = new Game(
            new Team('Team 1'),
            new Team('Team 2')
        );

        // When I get the score of the game
        $homeTeamScore = $game->getHomeTeamScore();
        $awayTeamScore = $game->getAwayTeamScore();

        // Then I expect the home team's score to be 0
        $this->assertSame(0, $homeTeamScore);
        // Then I expect the away team's score to be 0
        $this->assertSame(0, $awayTeamScore);
    }

    public function testUpdateScore(): void
    {
        // Given I have a game with two teams
        $game = new Game(
            new Team('Team 1'),
            new Team('Team 2')
        );

        // When I update the score of the game
        $game->updateScore(2, 1);

        $homeTeamScore = $game->getHomeTeamScore();
        $awayTeamScore = $game->getAwayTeamScore();

        // Then I expect the home team's score to be 2
        $this->assertSame(2, $homeTeamScore);
        // Then I expect the away team's score to be 1
        $this->assertSame(1, $awayTeamScore);
    }
}
