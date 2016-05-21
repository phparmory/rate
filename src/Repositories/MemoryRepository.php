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
        return $this->events;
    }

    /**
     * Finds all events that match
     * @param string $id
     * @return array
     */
    public function find($id)
    {
        $events = $this->events[$id] ?? [];
        sort($events);
        return $events;
    }

    /**
     * Count the number of matching events
     * @param string $id
     * @return int
     */
    public function count($id)
    {
        return count($this->find($id));
    }

    /**
     * Adds an event to the repository
     * @param string $id
     * @param EventInterface $event
     * @return void
     */
    public function add($id, EventInterface $event)
    {
        // Get existing events that have happened
        $existing = $this->find($id);

        // Add the event by timestamp
        $existing[] = $event->getTimestamp();

        // Update the events
        $this->events[$id] = $existing;
    }

    /**
     * Finds the events that happened between a min and max timestamp
     * @param string $id
     * @param int $min
     * @param int $max
     * @return array
     */
    public function between($id, int $min, int $max)
    {
        return array_filter($this->find($id), function($timestamp) use ($min, $max)
        {
            return $timestamp > $min && $timestamp < $max;
        });
    }

    /**
     * Finds the timestamp of the first occuring matching event
     * @param string $id
     * @return int|null
     */
    public function first($id)
    {
        $events = $this->find($id);
        return reset($events);
    }

    /**
     * Remove all events that happen before a min timestamp
     * @param string $id
     * @param int $min
     * @return void
     */
    public function removeBefore($id, int $min)
    {
        $events = array_filter($this->find($id), function($timestamp) use ($min)
        {
            return $timestamp > $min;
        });

        $this->events[$id] = $events;
    }
}
