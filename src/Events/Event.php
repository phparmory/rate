<?php

namespace Armory\Rate\Events;

use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Traits\RateLimitEvent;

class Event implements EventInterface
{
    use RateLimitEvent;

    /**
     * Creates a new event
     * @param string $id
     * @return void
     */
    public function __construct($id = null)
    {
        $this->eventId = $id;
    }
}
