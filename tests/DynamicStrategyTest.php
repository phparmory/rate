<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Exceptions\RateLimitExceededException;
use Armory\Rate\Repositories\MemoryRepository;
use Armory\Rate\Strategies\DynamicStrategy;
use Armory\Rate\Actors\Actor;
use Armory\Rate\Events\Event;
use PHPUnit_Framework_TestCase;

class DynamicStrategyTest extends PHPUnit_Framework_TestCase
{
    public function testAllow()
    {
        $repository = new MemoryRepository;
        $strategy = new DynamicStrategy($repository);

        $strategy->setAllow(5);

        $this->assertEquals(5, $strategy->getAllow());
    }

    public function testTimeframe()
    {
        $repository = new MemoryRepository;
        $strategy = new DynamicStrategy($repository);

        $strategy->setTimeframe(5);

        $this->assertEquals(5, $strategy->getTimeframe());
    }

    public function testRateLimitExceeded()
    {
        // We should expect this test to fail
        $this->setExpectedException(RateLimitExceededException::class);

        $repository = new MemoryRepository;
        $strategy = new DynamicStrategy($repository);
        $event = new Event;
        $actor = new Actor;

        // Set timeframe and allowed attempts
        $strategy->setTimeframe(2);
        $strategy->setAllow(1);

        // Handle the event twice
        $strategy->handle($actor, $event);
        sleep(1);
        $strategy->handle($actor, $event);
    }

    public function testRateLimitPasses()
    {
        $repository = new MemoryRepository;
        $strategy = new DynamicStrategy($repository);
        $event = new Event;
        $actor = new Actor;

        // Set timeframe and allowed attempts
        $strategy->setTimeframe(2);
        $strategy->setAllow(2);

        // Handle the event twice
        $strategy->handle($actor, $event);
        sleep(1);
        $strategy->handle($actor, $event);
        sleep(1);
        $strategy->handle($actor, $event);


        // This test has to assert that it didn't throw an exception
        $this->assertTrue(true);
    }

    public function testRateLimitFailsWithHighCost()
    {
        // We should expect this test to fail
        $this->setExpectedException(RateLimitExceededException::class);

        $repository = new MemoryRepository;
        $strategy = new DynamicStrategy($repository);
        $event = new Event;
        $actor = new Actor;

        // Set the cost to 5
        $event->setCost(5);

        // Set timeframe and allowed attempts
        $strategy->setTimeframe(1);
        $strategy->setAllow(1);

        // Handle the event twice
        $strategy->handle($actor, $event);
    }

    public function testRateLimitRemaining()
    {
        $repository = new MemoryRepository;
        $strategy = new DynamicStrategy($repository);
        $event = new Event;
        $actor = new Actor;

        // Set the cost to 5
        $event->setCost(5);

        // Set timeframe and allowed attempts
        $strategy->setTimeframe(1);
        $strategy->setAllow(10);

        // Handle the event twice
        $strategy->handle($actor, $event);

        $this->assertEquals(5, $strategy->getRemaining($actor, $event));
    }
}
