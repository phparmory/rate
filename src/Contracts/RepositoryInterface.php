<?php

namespace Armory\Rate\Contracts;

interface RepositoryInterface
{
    /**
     * Gets the whole repository
     * @return array
     */
    public function all();

    /**
     * Gets all matching events
     * @return array
     */
    public function find($id);

    /**
     * Count the number of matching events
     * @param string $id
     * @return int
     */
    public function count($id);

    /**
     * Adds an event to the repository
     * @param string $id
     * @param EventInterface $event
     * @return void
     */
    public function add($id, EventInterface $event);

    /**
     * Finds the events that happened between a min and max timestamp
     * @param string $id
     * @param int $min
     * @param int $max
     * @return array
     */
    public function between($id, int $min, int $max);

    /**
     * Finds the first occuring matching event
     * @param string $id
     * @return void
     */
    public function first($id);

    /**
     * Remove all events that happen before a min timestamp
     * @param string $id
     * @param int $min
     * @return void
     */
    public function removeBefore($id, int $min);
}
