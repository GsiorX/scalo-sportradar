<?php

declare(strict_types=1);

namespace AppTests\Unit;

use App\Exception\BadTeamNameException;
use App\Team\Team;
use PHPUnit\Framework\TestCase;

/** @covers \App\Team\Team */
final class TeamTest extends TestCase
{
    public function testTeamName(): void
    {
        // Given I have a team with a name 'Team 1'
        $team = new Team();
        $name = 'Team 1';
        $team->setName($name);

        // When I get the name of the team
        $name = $team->getName();

        // Then I expect the name to be 'Team 1'
        $this->assertSame('Team 1', $name);
    }

    public function testSettingTeamNameFailsWhenNameIsEmpty(): void
    {
        // Given I have a team with a name ''
        $team = new Team();
        $name = '';

        // Then I expect the exception to be thrown
        $this->expectException(BadTeamNameException::class);

        // When I set the name of the team
        $team->setName($name);
    }

    public function testSettingTeamNameFailsWhenNameIsAWhitespaceCharacter(): void
    {
        // Given I have a team with a name ' '
        $team = new Team();
        $name = ' ';

        // Then I expect the exception to be thrown
        $this->expectException(BadTeamNameException::class);

        // When I set the name of the team
        $team->setName($name);
    }
}
