<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface,
    Types\Integer,
    Types\StringLiteral,
    Types\Timestamp
};

class NullEvent implements EventInterface
{
    /**
     * Get the name of this event
     * @return String
     */
    public function getName() : StringLiteral
    {
        return new StringLiteral('');
    }

    /**
     * Get the cost of this event
     * @return Integer
     */
    public function getCost() : Integer
    {
        return new Integer(0);
    }

    /**
     * Get the name of this event
     * @return Timestamp
     */
    public function getTimestamp() : Timestamp
    {
        return new Timestamp(0);
    }

    /**
     * Get the actor that triggered this event
     * @return ActorInterface
     */
    public function getActor() : ActorInterface
    {
        return new NullActor();
    }

    /**
     * Calculates the time between this event and a timestamp
     * @param  Timestamp $timestamp
     * @return Integer
     */
    public function timeBetween(Timestamp $timestamp) : Integer
    {
        return new Integer(0);
    }
}
