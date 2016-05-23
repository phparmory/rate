<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\EventCollectionInterface,
    Contracts\EventInterface,
    Types\Integer
};

interface EventRepositoryInterface
{
    /**
     * Return all occurances of an event
     * @param  EventInterface                    $event
     * @return EventCollectionInterface
     */
    public function all(EventInterface $event) : EventCollectionInterface;

    /**
     * Add a new event to the repository
     * @param EventInterface $event [description]
     */
    public function add(EventInterface $event);

    /**
     * Get the last occurance of an event
     * @param  EventInterface  $event
     * @return EventInterface|null
     */
    public function last(EventInterface $event);

    /**
     * Get the first occurance of an event
     * @param  EventInterface  $event
     * @return EventInterface|null
     */
    public function first(EventInterface $event);

    /**
     * Count how many occurances there are of an event
     * @param  EventInterface   $event
     * @return Integer
     */
    public function count(EventInterface $event) : Integer;
}
