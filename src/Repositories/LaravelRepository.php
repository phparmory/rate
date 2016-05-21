<?php

namespace Armory\Rate\Repositories;

use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RepositoryInterface;
use Closure;
use Illuminate\Contracts\Cache\Repository as CacheContract;

class LaravelRepository implements RepositoryInterface
{
    /**
     * The Redis instance
     * @var
     */
    protected $cache;

    /**
     * Create a new Redis repository
     *
     * @param Illuminate\Contracts\Cache\Repository $cache
     * @return void
     */
    public function __construct(CacheContract $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Finds all events that match
     * @param string $id
     * @return array
     */
    public function find($id)
    {
        $events = (array) json_decode($this->cache->get($id, '[]'));
        sort($events);
        return array_map('intval', $events);
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
        $this->cache->forever($id, json_encode($existing));
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

        $this->cache->forever($id, json_encode($events));
    }
}
