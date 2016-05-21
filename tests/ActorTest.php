<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Tests\Stubs\TestActor;
use PHPUnit_Framework_TestCase;

class ActorTest extends PHPUnit_Framework_TestCase
{
    public function testGetIdentifier()
    {
        $actor = new TestActor;

        $this->assertEquals('1', $actor->getIdentifier());
    }
}
