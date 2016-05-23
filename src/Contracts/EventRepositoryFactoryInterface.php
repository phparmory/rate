<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\ActorInterface
};

interface EventRepositoryFactoryInterface
{
    /**
     * Make a new fake repository
     * @return EventRepositoryInterface
     */
    public function create() : EventRepositoryInterface;
}
