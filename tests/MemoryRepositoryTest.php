<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Repositories\MemoryRepository;
use Armory\Rate\Tests\Stubs\TestEvent;
use PHPUnit_Framework_TestCase;

class RepositoryTest extends PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;

        $repository->add($event->getIdentifier(), $event);

        // Find the timestamp for the event that was added
        $timestamps = $repository->find($event->getIdentifier());

        $this->assertEquals($event->getTimestamp(), $timestamps[0]);
    }

    public function testCount()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;

        $repository->add($event->getIdentifier(), $event);

        $this->assertEquals(1, $repository->count($event->getIdentifier()));
    }

    public function testBetween()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;

        // Set the timestamp to an abitrary number
        $event->setTimestamp(10);

        // Add it to the repository
        $repository->add($event->getIdentifier(), $event);

        // Get all timestamps between 9 and 11
        $timestamps = $repository->between($event->getIdentifier(), 9, 11);

        $this->assertEquals(1, count($timestamps));

        // Get all timestamps between 11 and 13
        $timestamps = $repository->between($event->getIdentifier(), 11, 13);

        $this->assertEquals(0, count($timestamps));
    }

    public function testFirst()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;
        $id = $event->getIdentifier();

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

    public function testRemoveBefore()
    {
        $repository = new MemoryRepository;
        $event = new TestEvent;
        $id = $event->getIdentifier();

        // Add the first
        $event->setTimestamp(10);
        $repository->add($id, $event);

        // Add the second
        $event->setTimestamp(20);
        $repository->add($id, $event);

        // Remove before 15
        $repository->removeBefore($id, 15);

        // Make sure there's 1 and that it's 20
        $this->assertEquals(1, $repository->count($id));
        $this->assertEquals(20, $repository->first($id));
    }
}
