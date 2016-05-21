<?php

namespace Armory\Rate\Strategies;

use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RepositoryInterface;
use Armory\Rate\Contracts\StrategyInterface;
use Armory\Rate\Exceptions\RateLimitExceededException;

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
        // Set the unique identifier of the event
        $event->setIdentifier($this->generateIdentifier($actor, $event));

        // Add the event to the repository
        $this->repository->add($event);

        // Get all matching events between two timestamps
        $events = $this->repository
            ->filter($event)
            ->between(
                $after = $this->getAfter($event),
                $before = $this->getBefore($event)
            );

        // If the rate limit is exceeded then throw an exception
        if (count($events) > $this->getAllow()) {
            throw new RateLimitExceededException('Rate limit exceeded');
        }

        // Garbage collect any old events
        $this->repository
            ->filter($event)
            ->remove($this->getTrashBefore($after, $before));
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
     * Generates a unique identifier based on an actor and event
     * @param ActorInterface $actor
     * @param EventInterface $event
     */
    protected function generateIdentifier(ActorInterface $actor, EventInterface $event)
    {
        return md5($actor->getIdentifier() . ':' . $event->getIdentifier());
    }
}
