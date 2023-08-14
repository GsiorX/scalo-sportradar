<?php

namespace AppTests\Unit;

use App\Game\Game;
use App\Scoreboard\Scoreboard;
use App\Team\Team;
use PHPUnit\Framework\TestCase;

/** @covers \App\Scoreboard\Scoreboard */
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

        // And I have startTime
        $startTime = (new \DateTimeImmutable())->getTimestamp();

        // When I start a game
        $scoreboard->startGame($game);

        // Then I expect the game to be in the list of games
        $this->assertCount(1, $scoreboard->getGames());

        // And I expect the game to have the correct start time
        $this->assertSame($game, $scoreboard->getGames()[$startTime]);
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

    public function testUpdateScore(): void
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

        // When I update the score of the game
        $scoreboard->updateScore($game, 1, 0);

        // Then I expect the home team's score to be 1
        $gameData = array_filter(
            $scoreboard->getGames(),
            fn(Game $game) => $game->getHomeTeamName() === $homeTeam->getName()
        );

        $this->assertSame(1, current($gameData)->getHomeTeamScore());
        $this->assertSame(0, current($gameData)->getAwayTeamScore());
    }

    public function testGetSummary(): void
    {
        // Given I have a scoreboard
        $scoreboard = new Scoreboard();

        // And I have eight teams
        $team1 = new Team();
        $team1->setName('Team 1');
        $team2 = new Team();
        $team2->setName('Team 2');
        $team3 = new Team();
        $team3->setName('Team 3');
        $team4 = new Team();
        $team4->setName('Team 4');
        $team5 = new Team();
        $team5->setName('Team 5');
        $team6 = new Team();
        $team6->setName('Team 6');
        $team7 = new Team();
        $team7->setName('Team 7');
        $team8 = new Team();
        $team8->setName('Team 8');

        // And I have four games
        $game1 = new Game();
        $game1->setHomeTeam($team1);
        $game1->setAwayTeam($team2);
        $game2 = new Game();
        $game2->setHomeTeam($team3);
        $game2->setAwayTeam($team4);
        $game3 = new Game();
        $game3->setHomeTeam($team5);
        $game3->setAwayTeam($team6);
        $game4 = new Game();
        $game4->setHomeTeam($team7);
        $game4->setAwayTeam($team8);

        // And I have started all four games
        $scoreboard->startGame($game1);
        $scoreboard->startGame($game2);
        $scoreboard->startGame($game3);
        $scoreboard->startGame($game4);

        // And I have updated the score of all four games
        $scoreboard->updateScore($game1, 1, 0);
        $scoreboard->updateScore($game2, 2, 1);
        $scoreboard->updateScore($game3, 3, 2);
        $scoreboard->updateScore($game4, 4, 3);

        // When I get the summary
        $summary = $scoreboard->getSummary();

        // Then I expect the summary to be correct
        $this->assertSame([
            'Team 7 4 - Team 8 3',
            'Team 5 3 - Team 6 2',
            'Team 3 2 - Team 4 1',
            'Team 1 1 - Team 2 0',
        ], $summary);
    }
}
