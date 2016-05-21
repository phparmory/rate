<?php

namespace Armory\Rate\Contracts;

interface EventInterface
{
    /**
     * Creates a new event
     * @param string $id
     * @return void
     */
    public function __construct($id);

    /**
     * Gets the cost of an event
     * @return int
     */
    public function getCost();

    /**
     * Sets the cost of an event
     * @param int $cost
     * @return void
     */
    public function setCost($cost);

    /**
     * Gets the unique rate identifier of this event
     * @return string
     */
    public function getEventId();

    /**
     * Sets the unique rate identifier for this event
     * @param string $identifier
     * @return void
     */
    public function setEventId($identifier);

    /**
     * Gets the timestamp when the event was fired
     * @return int
     */
    public function getTimestamp();

    /**
     * Sets the timestamp when the event was fired
     * @param int $timestamp
     * @return void
     */
    public function setTimestamp($timestamp);
}
