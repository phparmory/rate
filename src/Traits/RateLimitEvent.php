<?php

namespace Armory\Rate\Traits;

trait RateLimitEvent
{
    /**
     * The unique event identifier
     * @var string
     */
    protected $eventId;

    /**
     * The timestamp when the event was fired
     * @var int
     */
    protected $timestamp;

    /**
     * The cost of firing this event
     * @var int
     */
    protected $cost = 1;

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
    public function getCost()
    {
        return (int) $this->cost;
    }

    /**
     * Sets the cost of an event
     * @param int $cost
     * @return void
     */
    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    /**
     * Gets the unique rate identifier of this event
     * @return string
     */
    public function getEventId()
    {
        return (string) $this->eventId ?: static::class;
    }

    /**
     * Sets the unique rate identifier for this event
     * @param string $identifier
     * @return void
     */
    public function setEventId($identifier)
    {
        $this->eventId = $identifier;
    }

    /**
     * Gets the timestamp when the event was fired
     * @return int
     */
    public function getTimestamp()
    {
        return (int) $this->timestamp;
    }

    /**
     * Sets the timestamp when the event was fired
     * @param int $timestamp
     * @return void
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }
}
