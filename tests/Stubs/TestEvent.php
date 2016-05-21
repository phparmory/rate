<?php

namespace Armory\Rate\Tests\Stubs;

use Armory\Rate\Traits\RateLimitEvent;
use Armory\Rate\Contracts\EventInterface;

class TestEvent implements EventInterface
{
    use RateLimitEvent;

    protected $eventId = 1;

    protected $cost = 1;
}
