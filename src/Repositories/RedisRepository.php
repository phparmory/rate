<?php

namespace Armory\Rate\Repositories;

use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RepositoryInterface;
use Closure;
use Predis\ClientInterface;

class RedisRepository implements RepositoryInterface
{
    /**
     * The Redis instance
     * @var
     */
    protected $redis;

    /**
     * Create a new Redis repository
     *
     * @param Predis\ClientInterface $client
     * @return void
     */
    public function __construct(ClientInterface $client)
    {
        $this->redis = $client;
    }

    /**
     * Finds all events that match
     * @param string $id
     * @return array
     */
    public function find($id)
    {
        return array_map('intval', array_values($this->redis->zrange($id, 0, -1, 'WITHSCORES')));
    }

    /**
     * Count the number of matching events
     * @param string $id
     * @return int
     */
    public function count($id)
    {
        return $this->redis->zcard($id);
    }

    /**
     * Adds an event to the repository
     * @param string $id
     * @param EventInterface $event
     * @return void
     */
    public function add($id, EventInterface $event)
    {
        $member = uniqid();
        $score = $event->getTimestamp();

        for ($i = 0; $i < $event->getCost(); $i++) {
            $this->redis->zadd($id, [
                $member => $score
            ]);
        }
    }

    /**
     * Finds the timestamp of the first occuring matching event
     * @param string $id
     * @return int|null
     */
    public function first($id)
    {
        $first = array_values($this->redis->zrange($id, 0, 0, 'WITHSCORES'));
        return reset($first);
    }

    /**
     * Finds the timestamp of the first occuring matching event
     * @param string $id
     * @return int
     */
    public function last($id)
    {
        $first = array_values($this->redis->zrange($id, -1, -1, 'WITHSCORES'));
        return reset($first);
    }

    /**
     * Clear all events that happen before a min timestamp
     * @param string $id
     * @param int $min
     * @return void
     */
    public function clear($id, int $min)
    {
        $this->redis->zremrangebyscore($id, "-inf", "($min");
    }
}
