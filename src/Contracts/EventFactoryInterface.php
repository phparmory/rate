<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface
};

interface EventFactoryInterface
{
    /**
     * Makes a new event
     * @param string $name
     * @param int $cost
     * @param ActorInterface $actor
     * @return EventInterface
     */
    public function create($name, $cost, ActorInterface $actor) : EventInterface;
}
