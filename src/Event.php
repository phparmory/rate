<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface,
    Types\Boolean,
    Types\Integer,
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
     * @var Integer
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
     * @param Integer           $cost
     * @param Timestamp         $timestamp
     * @param ActorInterface    $actor
     * @return void
     */
    public function __construct(
        StringLiteral $name,
        Integer $cost,
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
     * @return Integer
     */
    public function getCost() : Integer
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
     * @return Boolean
     */
    public function equal(Event $event) : Boolean
    {
        return new Boolean($this->getId() === $event->getId());
    }

    /**
     * Calculates the time between this event and a timestamp
     * @param  Timestamp $timestamp
     * @return Integer
     */
    public function timeBetween(Timestamp $timestamp) : Integer
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
