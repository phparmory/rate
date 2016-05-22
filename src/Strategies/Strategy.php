<?php

namespace Armory\Rate\Strategies;

use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RepositoryInterface;
use Armory\Rate\Contracts\StrategyInterface;
use Armory\Rate\Exceptions\RateLimitExceededException;
use Armory\Rate\Exceptions\RateLimitPenaltyException;

abstract class Strategy implements StrategyInterface
{
    /**
     * How many events to allow within a timeframe
     * @var int
     */
    protected $allow;

    /**
     * What timeframe to allow events within in seconds
     * @var int
     */
    protected $timeframe;

    /**
     * The repository to store events in
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * The penalty for hitting the rate limit in seconds
     * @var int
     */
    protected $penalty;

    /**
     * Create a new strategy
     * @param RepositoryInterface $repository
     * @return void
     */
    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handles an event by an actor and determines if it's permissible
     * @param  ActorInterface $actor
     * @param  EventInterface $event
     * @return bool
     */
    public function handle(ActorInterface $actor, EventInterface $event)
    {
        if ($this->isPenalized($actor, $event)) {

            // Repenalize the actor
            $this->penalize($actor, $event);

            throw new RateLimitPenaltyException('Rate limit penalty incurred. Please try again later.');
        }

        // Generate a unique ID based on the actor and event
        $id = $this->generateIdentifier($actor, $event);

        // Garbage collect any old events
        $this->repository->clear($id, $this->getSince($id));

         // Check if one more would exceed the limit
        if ($this->repository->count($id) + $event->getCost() > $this->getAllow()) {

            // Penalize the actor for hitting the rate limit
            $this->penalize($actor, $event);

            throw new RateLimitExceededException('Rate limit has been reached. Please try again later.');
        }

        // Add the new event to the repository
        $this->repository->add($id, $event);
    }

    /**
     * Gets the remaining attempts for an event
     * @param ActorInterface $actor
     * @param EventInterface $event
     * @return int
     */
    public function getRemaining(ActorInterface $actor, EventInterface $event)
    {
        // Generate a unique ID based on the actor and event
        $id = $this->generateIdentifier($actor, $event);

        if ($this->isPenalized($actor, $event)) {
            return 0;
        }

        return $this->getAllow() - $this->repository->count($id);
    }

    /**
     * Checks if this user is penalized
     * @param ActorInterface $actor
     * @param EventInterface $event
     * @return boolean
     */
    public function isPenalized(ActorInterface $actor, EventInterface $event)
    {
        // Generate a unique ID based on the actor and event
        $id = $this->generateIdentifier($actor, $event);

        return $this->repository->last($id) > time();
    }

    /**
     * Get the timeout on the penalty in seconds from now
     * @param ActorInterface $actor
     * @param EventInterface $event
     * @return int
     */
    public function getPenaltyTimeout(ActorInterface $actor, EventInterface $event)
    {
        // Generate a unique ID based on the actor and event
        $id = $this->generateIdentifier($actor, $event);

        return $this->repository->last($id) - time();
    }

    /**
     * Sets the number of events to allow within a timeframe
     * @param int $allow
     */
    public function setAllow($allow)
    {
        $this->allow = $allow;
    }

    /**
     * Gets the number of events to allow within a timeframe
     * @return int
     */
    public function getAllow()
    {
        return (int) $this->allow;
    }

    /**
     * Sets the timeframe to allow events within in seconds
     * @param int $time
     */
    public function setTimeframe($timeframe)
    {
        $this->timeframe = $timeframe;
    }

    /**
     * Gets the timeframe to allow events within
     * @return int
     */
    public function getTimeframe()
    {
        return (int) $this->timeframe;
    }

    /**
     * Set a penalty for getting rate limited in seconds
     * @param int $penalty
     * @return void
     */
    public function setPenalty($penalty)
    {
        $this->penalty = $penalty;
    }

    /**
     * Get the penalty for getting rate limited in seconds
     * @return void
     */
    public function getPenalty()
    {
        return $this->penalty ?: null;
    }

    /**
     * Penalize an actor for a number of seconds
     * @param ActorInterface $actor
     * @param EventInterface $event
     * @return void
     */
    protected function penalize(ActorInterface $actor, EventInterface $event)
    {
        if (!$this->getPenalty()) {
            return;
        }

        $id = $this->generateIdentifier($actor, $event);

        // Get the last event (which could be a penalty)
        $last = $this->repository->last($id);

        // Clear previous events so we can just store a penalty
        $this->repository->clear($id, $last);

        // Set the penalty time to be a number of seconds after the last request
        $event->setTimestamp($last + $this->getPenalty());

        // Add the penalty to the repository
        $this->repository->add($id, $event);
    }

    /**
     * Generates a unique identifier based on an actor and event
     * @param ActorInterface $actor
     * @param EventInterface $event
     */
    protected function generateIdentifier(ActorInterface $actor, EventInterface $event)
    {
        return md5($actor->getActorId() . ':' . $event->getEventId());
    }
}
