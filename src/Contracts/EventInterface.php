<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\IntegerInterface,
    Types\StringLiteral,
    Types\Timestamp,
    Types\Boolean
};

interface EventInterface
{
    /**
     * Get the name of this event
     * @return String
     */
    public function getName() : StringLiteral;

    /**
     * Get the cost of this event
     * @return IntegerInterface
     */
    public function getCost() : IntegerInterface;

    /**
     * Get the name of this event
     * @return Timestamp
     */
    public function getTimestamp() : Timestamp;

    /**
     * Get the actor that triggered this event
     * @return ActorInterface
     */
    public function getActor() : ActorInterface;

    /**
     * Checks if this event is equal to another
     * @param EventInterface $event
     * @return Boolean
     */
    public function equal(EventInterface $event) : Boolean;

    /**
     * Calculates the time between this event and a timestamp
     * @param  Timestamp $timestamp
     * @return IntegerInterface
     */
    public function timeBetween(Timestamp $timestamp) : IntegerInterface;

    /**
     * Gets the ID of this event
     * @return String
     */
    public function getId() : StringLiteral;
}
