<?php

namespace Armory\Rate\Types;

use Assert\Assertion;
use SplFixedArray;
use Armory\Rate\{
    Contracts\EventCollectionInterface,
    Contracts\EventInterface,
    Contracts\TypeInterface,
    Contracts\IntegerInterface,
    NullEvent,
    Types\Integer,
    Types\Timestamp
};

final class EventCollection extends Type implements TypeInterface, EventCollectionInterface
{
    /**
     * Create a new value object
     * @param array $value
     */
    public function __construct($value)
    {
        Assertion::isArray($value);

        foreach ($value as $object) {
            Assertion::implementsInterface($object, EventInterface::class);
        }

        $this->value = SplFixedArray::fromArray($value);
    }

    /**
     * Returns the number of events in the collection
     * @return IntegerInterface
     */
    public function count() : IntegerInterface
    {
        return new Integer($this->value->count());
    }

    /**
     * Filters the collection for matching events
     * @param EventInterface $event
     * @return EventCollection
     */
    public function filter(EventInterface $event) : EventCollection
    {
        return new self(array_filter($this->value->toArray(), function($stored) use ($event)
        {
            return $stored->equal($event);
        }));
    }

    /**
     * Get all events after a timestamp
     * @param Timestamp $timestamp
     * @return EventCollection
     */
    public function after(Timestamp $timestamp) : EventCollection
    {
        return new self(array_filter($this->value->toArray(), function($stored) use ($timestamp)
        {
            return $stored->timeBetween($timestamp)->toInt() >= 0;
        }));
    }

    /**
     * Get the first event in the collection
     * @return EventInterface
     */
    public function first() : EventInterface
    {
        return $this->collection[0] ?? new NullEvent;
    }

    /**
     * Get the last event in the collection
     * @return EventInterface
     */
    public function last() : EventInterface
    {
        $last = $this->value->count() - 1;

        return $this->collection[$last] ?? new NullEvent;
    }

    /**
     * Converts the collection to an array
     * @return array
     */
    public function toArray() : array
    {
        return $this->value->toArray();
    }

    /**
     * Cast the object to a string
     * @return string
     */
    public function __toString() : string
    {
        $string = \sprintf('%s(%d)', \get_class($this), $this->count()->toNative());

        return $string;
    }
}
