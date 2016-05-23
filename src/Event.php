<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface,
    Types\Boolean,
    Types\Integer,
    Contracts\IntegerInterface,
    Types\StringLiteral,
    Types\Timestamp
};

final class Event implements EventInterface
{
    /**
     * The name of this event
     * @var StringLiteral
     */
    private $name;

    /**
     * The cost of this event
     * @var IntegerInterface
     */
    private $cost;

    /**
     * The time this event occured
     * @var Timestamp
     */
    private $timestamp;

    /**
     * The actor triggering the event
     * @var ActorInterface
     */
    protected $actor;

    /**
     * Create a new event entity
     * @param StringLiteral     $name
     * @param IntegerInterface  $cost
     * @param Timestamp         $timestamp
     * @param ActorInterface    $actor
     * @return void
     */
    public function __construct(
        StringLiteral $name,
        IntegerInterface $cost,
        Timestamp $timestamp,
        ActorInterface $actor)
    {
        $this->name = $name;
        $this->cost = $cost;
        $this->timestamp = $timestamp;
        $this->actor = $actor;
    }

    /**
     * Get the name of this event
     * @return String
     */
    public function getName() : StringLiteral
    {
        return $this->name;
    }

    /**
     * Get the cost of this event
     * @return IntegerInterface
     */
    public function getCost() : IntegerInterface
    {
        return $this->cost;
    }

    /**
     * Get the name of this event
     * @return Timestamp
     */
    public function getTimestamp() : Timestamp
    {
        return $this->timestamp;
    }

    /**
     * Get the actor that triggered this event
     * @return ActorInterface
     */
    public function getActor() : ActorInterface
    {
        return $this->actor;
    }

    /**
     * Checks if this event is equal to another
     * @param EventInterface $event
     * @return Boolean
     */
    public function equal(EventInterface $event) : Boolean
    {
        return new Boolean($this->getId() === $event->getId());
    }

    /**
     * Calculates the time between this event and a timestamp
     * @param  Timestamp $timestamp
     * @return IntegerInterface
     */
    public function timeBetween(Timestamp $timestamp) : IntegerInterface
    {
        return new Integer($this->getTimestamp()->toInt() - $timestamp->toInt());
    }

    /**
     * Gets the ID of this event
     * @return String
     */
    public function getId() : StringLiteral
    {
        return new StringLiteral(md5($this->actor->getIp() . ':' . $this->getName()));
    }
}
