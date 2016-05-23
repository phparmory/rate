<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\EventInterface,
    Contracts\IntegerInterface,
    Types\EventCollection,
    Types\Timestamp
};

interface EventCollectionInterface
{
    /**
     * Returns the number of events in the collection
     * @return IntegerInterface
     */
    public function count() : IntegerInterface;

    /**
     * Filters the collection for matching events
     * @param EventInterface $event
     * @return EventCollection
     */
    public function filter(EventInterface $event) : EventCollection;

    /**
     * Get all events after a timestamp
     * @param Timestamp $timestamp
     * @return EventCollection
     */
    public function after(Timestamp $timestamp) : EventCollection;

    /**
     * Get the first event in the collection
     * @return EventInterface
     */
    public function first() : EventInterface;

    /**
     * Get the last event in the collection
     * @return EventInterface
     */
    public function last() : EventInterface;

    /**
     * Converts the collection to an array
     * @return array
     */
    public function toArray() : array;
}
