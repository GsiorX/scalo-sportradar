<?php

declare(strict_types=1);

namespace AppTests\Unit;

use App\Exception\NegativeScoreException;
use App\Exception\NonUniqueTeamNameException;
use App\Exception\StartGameException;
use App\Game\Game;
use App\Team\Team;
use Generator;
use PHPUnit\Framework\TestCase;

/** @covers \App\Game\Game */
final class GameTest extends TestCase
{
    public function testGetTeamNames(): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);

        // When I get the names of the teams
        $homeTeamName = $game->getHomeTeamName();
        $awayTeamName = $game->getAwayTeamName();

        // Then I expect the home team to be 'Team 1'
        $this->assertSame('Team 1', $homeTeamName);
        // And I expect the away team to be 'Team 2'
        $this->assertSame('Team 2', $awayTeamName);
    }

    public function testGetTeamNamesButAwayTeamGetsSetFirst(): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setAwayTeam($team2);
        $game->setHomeTeam($team1);

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
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);

        // When I get the score of the game
        $homeTeamScore = $game->getHomeTeamScore();
        $awayTeamScore = $game->getAwayTeamScore();

        // Then I expect the home team's score to be 0
        $this->assertSame(0, $homeTeamScore);
        // Then I expect the away team's score to be 0
        $this->assertSame(0, $awayTeamScore);
    }

    public function testStartGameSetsStartTime(): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);

        // And I have a start time
        $startTime = (new \DateTimeImmutable())->getTimestamp();

        // When I start the game
        $game->startGame();

        // Then I expect the start time to be set
        $this->assertSame($startTime, $game->getStartTime());
    }

    public function testStartGameFailsIfOnlyHomeTeamIsSet(): void
    {
        // Given I have a game with one team only
        $team1Name = 'Team 1';

        $team1 = new Team();
        $team1->setName($team1Name);

        $game = new Game();
        $game->setHomeTeam($team1);

        // Then I expect an exception to be thrown
        $this->expectException(StartGameException::class);

        // When I start the game
        $game->startGame();
    }

    public function testStartGameFailsIfOnlyAwayTeamIsSet(): void
    {
        // Given I have a game with one team only
        $team1Name = 'Team 1';

        $team1 = new Team();
        $team1->setName($team1Name);

        $game = new Game();
        $game->setAwayTeam($team1);

        // Then I expect an exception to be thrown
        $this->expectException(StartGameException::class);

        // When I start the game
        $game->startGame();
    }

    public function testStartGameFailsIfScoreHasBeenSet(): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setAwayTeam($team1);
        $game->setHomeTeam($team2);

        // And I set the score before starting the match
        $game->updateScore(1, 0);

        // Then I expect an exception to be thrown
        $this->expectException(StartGameException::class);

        // When I start the game
        $game->startGame();
    }

    public function testSetStartTime(): void
    {
        // Given I have a game
        $game = new Game();

        // When I set the start time
        $startTime = (new \DateTimeImmutable())->getTimestamp();

        // Then I expect the start time to be set
        $game->setStartTime($startTime);
        $this->assertSame($startTime, $game->getStartTime());
    }

    public function testUpdateScore(): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);

        // When I update the score of the game
        $game->updateScore(2, 1);

        $homeTeamScore = $game->getHomeTeamScore();
        $awayTeamScore = $game->getAwayTeamScore();

        // Then I expect the home team's score to be 2
        $this->assertSame(2, $homeTeamScore);
        // Then I expect the away team's score to be 1
        $this->assertSame(1, $awayTeamScore);
    }

    public function testUpdateScoreToZeroesWorks(): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);

        // When I update the score of the game
        $game->updateScore(0, 0);

        $homeTeamScore = $game->getHomeTeamScore();
        $awayTeamScore = $game->getAwayTeamScore();

        // Then I expect the home team's score to be 2
        $this->assertSame(0, $homeTeamScore);
        // Then I expect the away team's score to be 1
        $this->assertSame(0, $awayTeamScore);
    }

    public function testUpdateScoreWithZeroWorks(): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);

        // Then I expect the exception to be thrown
        $this->expectException(NegativeScoreException::class);

        // When I update the score of the game
        $game->updateScore(-1, 0);
    }

    /**
     * @dataProvider provideScenariosForScoreValidation
     * @param array<string, int> $score
     * @throws NegativeScoreException
     */
    public function testUpdateScoreWithNegativeValueFails(array $score): void
    {
        // Given I have a game with two teams
        $team1Name = 'Team 1';
        $team2Name = 'Team 2';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);

        // Then I expect the exception to be thrown
        $this->expectException(NegativeScoreException::class);

        // When I update the score of the game
        $game->updateScore($score['homeTeamScore'], $score['awayTeamScore']);
    }

    public function testSettingSameTeamNameTwiceFails(): void
    {
        // Given I have a game with two teams with the same name
        $team1Name = 'Team 1';
        $team2Name = 'Team 1';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        // Then I expect the exception to be thrown
        $this->expectException(NonUniqueTeamNameException::class);

        // When I set the names of the teams
        $game = new Game();
        $game->setHomeTeam($team1);
        $game->setAwayTeam($team2);
    }

    public function testSettingSameTeamNameTwiceFailsButAwayTeamGetsSetFirst(): void
    {
        // Given I have a game with two teams with the same name
        $team1Name = 'Team 1';
        $team2Name = 'Team 1';

        $team1 = new Team();
        $team1->setName($team1Name);
        $team2 = new Team();
        $team2->setName($team2Name);

        // Then I expect the exception to be thrown
        $this->expectException(NonUniqueTeamNameException::class);

        // When I set the names of the teams
        $game = new Game();
        $game->setAwayTeam($team2);
        $game->setHomeTeam($team1);
    }

    public static function provideScenariosForScoreValidation(): Generator
    {
        yield 'negative home team score' => [
            [
                'homeTeamScore' => -1,
                'awayTeamScore' => 0,
            ],
        ];

        yield 'negative away team score' => [
            [
                'homeTeamScore' => 0,
                'awayTeamScore' => -1,
            ],
        ];

        yield 'negative home and away team score' => [
            [
                'homeTeamScore' => -1,
                'awayTeamScore' => -1,
            ],
        ];

        yield 'negative home team score and positive away team score' => [
            [
                'homeTeamScore' => -1,
                'awayTeamScore' => 1,
            ],
        ];

        yield 'positive home team score and negative away team score' => [
            [
                'homeTeamScore' => 1,
                'awayTeamScore' => -1,
            ],
        ];

        yield 'zero home team score and negative away team score' => [
            [
                'homeTeamScore' => 0,
                'awayTeamScore' => -1,
            ],
        ];

        yield 'negative home team score and zero away team score' => [
            [
                'homeTeamScore' => -1,
                'awayTeamScore' => 0,
            ],
        ];
    }
}
