<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\ActorInterface,
    Types\Integer,
    Types\StringLiteral,
    Types\Timestamp
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
     * @return Integer
     */
    public function getCost() : Integer;

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
     * Calculates the time between this event and a timestamp
     * @param  Timestamp $timestamp
     * @return Integer
     */
    public function timeBetween(Timestamp $timestamp) : Integer;
}
