<?php

namespace Armory\Rate\Traits;

trait RateLimitEvent
{
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
     * The unique id for this event
     * @var string
     */
    protected $eventId;

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
        return static::class . ':' . $this->eventId;
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
        return isset($this->timestamp) ? $this->timestamp : time();
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
