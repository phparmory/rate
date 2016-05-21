<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Repositories\MemoryRepository;
use Armory\Rate\Tests\Stubs\TestEvent;
use PHPUnit_Framework_TestCase;

class MemoryRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;

        $repository->add($event->getEventId(), $event);

        // Find the timestamp for the event that was added
        $timestamps = $repository->find($event->getEventId());

        $this->assertEquals($event->getTimestamp(), $timestamps[0]);
    }

    public function testCount()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;

        $repository->add($event->getEventId(), $event);

        $this->assertEquals(1, $repository->count($event->getEventId()));
    }

    public function testFirst()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;
        $id = $event->getEventId();

        // Add the first
        $event->setTimestamp(10);
        $repository->add($id, $event);

        // Add the second
        $event->setTimestamp(20);
        $repository->add($id, $event);

        // Add the last
        $event->setTimestamp(30);
        $repository->add($id, $event);

        // Assert that all three were added
        $this->assertEquals(3, $repository->count($id));

        // Get the first
        $this->assertEquals(10, $repository->first($id));
    }

    public function testClear()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;
        $id = $event->getEventId();

        // Add the first
        $event->setTimestamp(10);
        $repository->add($id, $event);

        // Add the second
        $event->setTimestamp(20);
        $repository->add($id, $event);

        // Remove before 15
        $repository->clear($id, 15);

        // Make sure there's 1 and that it's 20
        $this->assertEquals(1, $repository->count($id));
        $this->assertEquals(20, $repository->first($id));
    }
}
