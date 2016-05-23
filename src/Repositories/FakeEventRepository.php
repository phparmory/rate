<?php

namespace Armory\Rate\Repositories;

use Armory\Rate\{
    Contracts\EventCollectionInterface,
    Contracts\EventInterface,
    Contracts\EventRepositoryInterface,
    Types\EventCollection,
    Types\Integer,
    Types\Timestamp
};

final class FakeEventRepository implements EventRepositoryInterface
{
    /**
     * The events in the repository
     * @var EventCollection
     */
    private $collection;

    /**
     * Create a new repository
     * @return void
     */
    public function __construct(EventCollectionInterface $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Return all occurances of an event
     * @param  EventInterface $event
     * @return EventCollectionInterface
     */
    public function all(EventInterface $event) : EventCollectionInterface
    {
        return $this->collection->filter($event);
    }

    /**
     * Add a new event to the repository
     * @param EventInterface $event
     */
    public function add(EventInterface $event)
    {
        $collection = $this->collection->toArray();

        $collection[] = $event;

        $this->collection = new EventCollection($collection);
    }

    /**
     * Get the last occurance of an event
     * @param  EventInterface  $event
     * @return EventInterface
     */
    public function last(EventInterface $event) : EventInterface
    {
        return $this->all($event)->last();
    }

    /**
     * Get the first occurance of an event
     * @param  EventInterface  $event
     * @return EventInterface
     */
    public function first(EventInterface $event) : EventInterface
    {
        return $this->all($event)->first();
    }

    /**
     * Count how many occurances there are of an event
     * @param  EventInterface   $event
     * @return Integer
     */
    public function count(EventInterface $event) : Integer
    {
        return $this->all($event)->count();
    }

    /**
     * Cleans the repository of all events before a timestamp
     * @param EventInterface $event
     * @param Timestamp $timestamp
     * @return void
     */
    public function cleanse(EventInterface $event, Timestamp $timestamp)
    {
        $this->collection = $this->collection->filter($event)->after($timestamp);
    }
}
