<?php

namespace Armory\Rate\Tests\Stubs;

use Armory\Rate\Traits\RateLimitActor;
use Armory\Rate\Contracts\ActorInterface;

class TestActor implements ActorInterface
{
    use RateLimitActor;

    protected $actorId = 1;
}
