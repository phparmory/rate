<?php

namespace Armory\Rate\Contracts;

interface RepositoryInterface
{
    /**
     * Gets all matching events
     * @param  EventInterface $event
     * @return array
     */
    public function all();

    /**
     * Adds an event to the repository
     * @param EventInterface $event
     */
    public function add(EventInterface $event);

    /**
     * Prepares the repository to filter by event
     * @return EventInterface $event
     */
    public function filter(EventInterface $event);

    /**
     * Finds the events that happened between a min and max timestamp
     * @param EventInterface $event
     * @param int $min
     * @param int $max
     * @return array
     */
    public function between(int $min, int $max);

    /**
     * Finds the first occuring matching event
     * @param EventInterface $event
     * @return void
     */
    public function first();

    /**
     * Remove all events that happen before a min timestamp
     * @param EventInterface $event
     * @param int $min
     * @return void
     */
    public function remove(int $min);
}
