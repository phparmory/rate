<?php

namespace Armory\Rate\Contracts;

interface StrategyInterface
{
    /**
     * Create a new strategy
     * @param RepositoryInterface $repository
     * @return void
     */
    public function __construct(RepositoryInterface $repository);

    /**
     * Handles an event by an actor and determines if it's permissible
     * @param  ActorInterface $actor
     * @param  EventInterface $event
     * @return bool
     */
    public function handle(ActorInterface $actor, EventInterface $event);

    /**
     * Gets the remaining attempts for an event
     * @param ActorInterface $actor
     * @param EventInterface $event
     * @return int
     */
    public function getRemaining(ActorInterface $actor, EventInterface $event);

    /**
     * Sets the number of events to allow within a timeframe
     * @param int $allow
     */
    public function setAllow($allow);

    /**
     * Gets the number of events to allow within a timeframe
     * @return int
     */
    public function getAllow();

    /**
     * Sets the timeframe to allow events within
     * @param int $time
     */
    public function setTimeframe($timeframe);

    /**
     * Gets the timeframe to allow events within
     * @return int
     */
    public function getTimeframe();

    /**
     * Gets the timestamp after which events are counted for rate limiting
     * @param string $id
     * @return int
     */
    public function getSince($id);
}
