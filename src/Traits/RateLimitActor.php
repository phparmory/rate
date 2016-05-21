<?php

namespace Armory\Rate\Traits;

trait RateLimitActor
{
    protected $actorId;

    /**
     * Returns the unique identifier for this actor
     * @return string
     */
    public function getActorId()
    {
        return static::class . ':' . $this->actorId;
    }
}
