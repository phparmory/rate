<?php

namespace Armory\Rate\Repositories;

use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RepositoryInterface;
use Closure;

class MemoryRepository implements RepositoryInterface
{
    /**
     * Stores the events that have happened
     * @var array
     */
    protected $events = [];

    /**
     * Finds all events that match
     * @param string $id
     * @return array
     */
    public function find($id)
    {
        $events = isset($this->events[$id]) ? $this->events[$id] : [];
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

        // Add the event by timestamp a number of times based on
        // the cost of the event
        for ($i = 0; $i < $event->getCost(); $i++) {
            $existing[] = $event->getTimestamp();
        }

        // Update the events
        $this->events[$id] = $existing;
    }

    /**
     * Finds the timestamp of the first occuring matching event
     * @param string $id
     * @return int
     */
    public function first($id)
    {
        $events = $this->find($id);
        return reset($events);
    }

    /**
     * Finds the timestamp of the first occuring matching event
     * @param string $id
     * @return int
     */
    public function last($id)
    {
        $events = array_reverse($this->find($id));
        return reset($events);
    }

    /**
     * Clear all events that happen before a min timestamp
     * @param string $id
     * @param int $min
     * @return void
     */
    public function clear($id, int $min)
    {
        $events = array_filter($this->find($id), function($timestamp) use ($min)
        {
            return $timestamp > $min;
        });

        $this->events[$id] = $events;
    }
}
