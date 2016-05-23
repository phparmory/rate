<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface,
    Contracts\IntegerInterface,
    Types\Integer,
    Types\StringLiteral,
    Types\Timestamp,
    Types\Boolean
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
     * @return IntegerInterface
     */
    public function getCost() : IntegerInterface
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
     * Checks if this event is equal to another
     * @param EventInterface $event
     * @return Boolean
     */
    public function equal(EventInterface $event) : Boolean
    {
        return new Boolean(false);
    }

    /**
     * Calculates the time between this event and a timestamp
     * @param  Timestamp $timestamp
     * @return IntegerInterface
     */
    public function timeBetween(Timestamp $timestamp) : IntegerInterface
    {
        return new Integer(0);
    }

    /**
     * Gets the ID of this event
     * @return String
     */
    public function getId() : StringLiteral
    {
        return new StringLiteral('');
    }
}
