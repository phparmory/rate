<?php

namespace Armory\Rate\Actors;

use Armory\Rate\Contracts\ActorInterface;

abstract class Actor implements ActorInterface
{
    /**
     * The unique identifier for this actor
     * @var int
     */
    protected $id;

    /**
     * Returns the unique identifier for this actor
     * @return string
     */
    public function getIdentifier()
    {
        return $this->id;
    }
}
