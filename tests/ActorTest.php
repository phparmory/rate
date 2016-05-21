<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Actors\Actor;
use PHPUnit_Framework_TestCase;

class ActorTest extends PHPUnit_Framework_TestCase
{
    public function testGetIdentifier()
    {
        $actor = new Actor(1);

        $this->assertEquals(Actor::class . ':1', $actor->getActorId());
    }
}
