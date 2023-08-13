<?php

namespace unit;

use App\ScaloSportradar\Team;
use PHPUnit\Framework\TestCase;

/** @covers \App\ScaloSportradar\Team */
class TeamTest extends TestCase
{
    public function testTeamName(): void
    {
        // Given I have a team with a name 'Team 1'
        $team = new Team('Team 1');

        // When I get the name of the team
        $name = $team->getName();

        // Then I expect the name to be 'Team 1'
        $this->assertSame('Team 1', $name);
    }
}
