<?php

namespace Armory\Rate\Repositories;

use Armory\Rate\Contracts\EventInterface;
use Closure;

class MemoryRepository extends Repository
{
    /**
     * Stores the events that have happened
     * @var array
     */
    protected $events = [];

    /**
     * Gets all events
     * @param  EventInterface $event
     * @return array
     */
    public function all()
    {
        $events = $this->events;

        if ($this->filter) {
            $events = $this->events[$this->filter->getIdentifier()] ?? [];
            sort($events);
        }

        return $events;
    }

    /**
     * Adds an event to the repository
     * @param EventInterface $event
     * @return void
     */
    public function add(EventInterface $event)
    {
        // Get existing events that have happened
        $existing = $this->filter($event)->all();

        // Add the event by timestamp
        $existing[] = $event->getTimestamp();

        // Update the events
        $this->events[$event->getIdentifier()] = $existing;
    }

    /**
     * Finds the events that happened between a min and max timestamp
     * @param EventInterface $event
     * @param int $min
     * @param int $max
     * @return array
     */
    public function between(int $min, int $max)
    {
        return array_filter($this->all(), function($timestamp) use ($min, $max)
        {
            return $timestamp >= $min && $timestamp < $max;
        });
    }

    /**
     * Finds the timestamp of the first occuring matching event
     * @param EventInterface $event
     * @return int|null
     */
    public function first()
    {
        if (!$this->filter) {
            return null;
        }

        $events = $this->all();
        return reset($events);
    }

    /**
     * Remove all events that happen before a min timestamp
     * @param EventInterface $event
     * @param int $min
     * @return void
     */
    public function remove(int $min)
    {
        $events = array_filter($this->all(), function($timestamp) use ($min)
        {
            return $timestamp >= $min;
        });

        $this->events[$this->filter->getIdentifier()] = $events;
    }
}
