<?php

namespace Armory\Rate\Tests\Stubs;

use Armory\Rate\Events\Event;

class TestEvent extends Event
{
    protected $id = 1;

    protected $cost = 1;
}
