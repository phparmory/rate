<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Exceptions\RateLimitExceededException;
use Armory\Rate\Repositories\MemoryRepository;
use Armory\Rate\Strategies\BasicStrategy;
use Armory\Rate\Tests\Stubs\TestActor;
use Armory\Rate\Tests\Stubs\TestEvent;
use PHPUnit_Framework_TestCase;

class BasicStrategyTest extends PHPUnit_Framework_TestCase
{
    public function testAllow()
    {
        $repository = new MemoryRepository;
        $strategy = new BasicStrategy($repository);

        $strategy->setAllow(5);

        $this->assertEquals(5, $strategy->getAllow());
    }

    public function testTimeframe()
    {
        $repository = new MemoryRepository;
        $strategy = new BasicStrategy($repository);

        $strategy->setTimeframe(5);

        $this->assertEquals(5, $strategy->getTimeframe());
    }

    public function testGetBefore()
    {
        $repository = new MemoryRepository;
        $strategy = new BasicStrategy($repository);
        $event = new TestEvent;

        // Set the timeframe in seconds
        $strategy->setTimeframe(5);

        // Add the event to the repository
        $repository->add($event->getIdentifier(), $event);

        // Before should be 5 seconds after the first
        $this->assertEquals(time() + 5, $strategy->getBefore($event->getIdentifier()));
    }

    public function testGetAfter()
    {
        $repository = new MemoryRepository;
        $strategy = new BasicStrategy($repository);
        $event = new TestEvent;

        // Set the timeframe in seconds
        $strategy->setTimeframe(5);

        // Add the event to the repository
        $repository->add($event->getIdentifier(), $event);

        // After should be a second before the first event
        $this->assertEquals($event->getTimestamp() - 1, $strategy->getAfter($event->getIdentifier()));
    }

    public function testTrashBefore()
    {
        $repository = new MemoryRepository;
        $strategy = new BasicStrategy($repository);
        $event = new TestEvent;

        // Set the timeframe in seconds
        $strategy->setTimeframe(5);

        // Add the event to the repository
        $repository->add($event->getIdentifier(), $event);

        // Trash everything before the first event
        $this->assertEquals(
            $event->getTimestamp() - 1,
            $strategy->getTrashBefore(
                $strategy->getAfter($event->getIdentifier()),
                $strategy->getBefore($event->getIdentifier())
            )
        );
    }

    public function testRateLimitExceeded()
    {
        // We should expect this test to fail
        $this->setExpectedException(RateLimitExceededException::class);

        $repository = new MemoryRepository;
        $strategy = new BasicStrategy($repository);
        $event = new TestEvent;
        $actor = new TestActor;

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
        $strategy = new BasicStrategy($repository);
        $event = new TestEvent;
        $actor = new TestActor;

        // Set timeframe and allowed attempts
        $strategy->setTimeframe(2);
        $strategy->setAllow(2);

        // Handle the event twice
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
        $strategy = new BasicStrategy($repository);
        $event = new TestEvent;
        $actor = new TestActor;

        // Set the cost to 5
        $event->setCost(5);

        // Set timeframe and allowed attempts
        $strategy->setTimeframe(1);
        $strategy->setAllow(1);

        // Handle the event twice
        $strategy->handle($actor, $event);
    }
}
