<?php

namespace Armory\Rate\Actors;

use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Traits\RateLimitActor;

class Guest implements ActorInterface
{
    use RateLimitActor;

    /**
     * Create a new guest
     * @param int $id
     * @return void
     */
    public function __construct($id)
    {
        $this->actorId = $id;
    }
}
