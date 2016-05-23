<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\EventCollectionInterface,
    Contracts\EventInterface,
    Contracts\IntegerInterface,
    Types\Timestamp
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
     * @return EventInterface
     */
    public function last(EventInterface $event) : EventInterface;

    /**
     * Get the first occurance of an event
     * @param  EventInterface  $event
     * @return EventInterface
     */
    public function first(EventInterface $event) : EventInterface;

    /**
     * Count how many occurances there are of an event
     * @param  EventInterface   $event
     * @return IntegerInterface
     */
    public function count(EventInterface $event) : IntegerInterface;

    /**
     * Cleans the repository of all events before a timestamp
     * @param EventInterface $event
     * @param Timestamp $timestamp
     * @return void
     */
    public function cleanse(EventInterface $event, Timestamp $timestamp);
}
