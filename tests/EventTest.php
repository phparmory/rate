<?php

namespace Armory\Rate\Tests;

use Armory\Rate\Events\Event;
use PHPUnit_Framework_TestCase;

class EventTest extends PHPUnit_Framework_TestCase
{
    public function testCost()
    {
        $event = new Event();

        $event->setCost(100);

        $this->assertEquals(100, $event->getCost());
    }

    public function testEventId()
    {
        $event = new Event;

        $event->setEventId('test.event');

        $this->assertEquals(Event::class . ':test.event', $event->getEventId());
    }

    public function testGetTimestamp()
    {
        $event = new Event;

        $this->assertEquals(time(), $event->getTimestamp());
    }
}
