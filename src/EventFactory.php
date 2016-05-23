<?php

namespace Armory\Rate;

use Armory\Rate\{
    Actor,
    Contracts\ActorInterface,
    Contracts\EventFactoryInterface,
    Contracts\EventInterface,
    Event,
    Types\Integer,
    Types\StringLiteral,
    Types\Timestamp
};

class EventFactory implements EventFactoryInterface
{
    /**
     * Makes a new event
     * @param string $name
     * @param int $cost
     * @param ActorInterface $actor
     * @return EventInterface
     */
    public function create($name, $cost, ActorInterface $actor) : EventInterface
    {
        return new Event(
            new StringLiteral($name),
            new Integer($cost),
            new Timestamp(time()),
            $actor
        );
    }
}
