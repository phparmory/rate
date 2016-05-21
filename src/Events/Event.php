<?php

namespace Armory\Rate\Events;

use Armory\Rate\Contracts\EventInterface;

abstract class Event implements EventInterface
{
    /**
     * The unique event identifier
     * @var string
     */
    protected $id;

    /**
     * The timestamp when the event was fired
     * @var int
     */
    protected $timestamp;

    /**
     * The cost of firing this event
     * @var int
     */
    protected $cost;

    /**
     * Creates a new event
     * @return void
     */
    function __construct()
    {
        $this->timestamp = time();
    }

    /**
     * Gets the cost of an event
     * @return int
     */
    public function getCost() : int
    {
        return (int) $this->cost;
    }

    /**
     * Gets the unique rate identifier of this event
     * @return string
     */
    public function getIdentifier() : string
    {
        return (string) $this->id;
    }

    /**
     * Sets the unique rate identifier for this event
     * @param string $identifier
     * @return void
     */
    public function setIdentifier($identifier)
    {
        $this->id = $identifier;
    }

    /**
     * Gets the timestamp when the event was fired
     * @return int
     */
    public function getTimestamp() : int
    {
        return (int) $this->timestamp;
    }
}
