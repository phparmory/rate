<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Events\Event;
use Armory\Rate\Tests\Stubs\TestEvent;
use PHPUnit_Framework_TestCase;

class EventTest extends PHPUnit_Framework_TestCase
{
    public function testGetCost()
    {
        $event = new TestEvent;

        $this->assertEquals(1, $event->getCost());
    }

    public function testSetCost()
    {
        $event = new TestEvent;

        $event->setCost(100);

        $this->assertEquals(100, $event->getCost());
    }

    public function testGetIdentifier()
    {
        $event = new TestEvent;

        $this->assertEquals(1, $event->getIdentifier());
    }

    public function testSetIdentifier()
    {
        $event = new TestEvent;

        $event->setIdentifier('test.event');

        $this->assertEquals('test.event', $event->getIdentifier());
    }

    public function testGetTimestamp()
    {
        $event = new TestEvent;

        $this->assertEquals(time(), $event->getTimestamp());
    }
}
