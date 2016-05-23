<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\EventInterface,
    Types\EventCollection,
    Types\Integer
};

interface EventCollectionInterface
{
    /**
     * Returns the number of events in the collection
     * @return Integer
     */
    public function count() : Integer;

    /**
     * Filters the collection for matching events
     * @param EventInterface $event
     * @return EventCollection
     */
    public function filter(EventInterface $event) : EventCollection;

    /**
     * Get the first event in the collection
     * @return Event|null
     */
    public function first();

    /**
     * Get the last event in the collection
     * @return Event|null
     */
    public function last();

    /**
     * Converts the collection to an array
     * @return array
     */
    public function toArray() : array;
}
