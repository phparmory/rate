<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface,
    Contracts\EventRepositoryInterface,
    Contracts\RateLimitInterface,
    Contracts\RateLimiterInterface,
    Event,
    Exceptions\RateLimitExceededException,
    Types\Boolean,
    Types\Integer,
    Contracts\IntegerInterface,
    Types\Timestamp
};

abstract class RateLimiter implements RateLimiterInterface
{
    /**
     * The event being triggered
     * @var EventInterface
     */
    protected $event;

    /**
     * The rate limit being imposed
     * @var RateLimitInterface
     */
    protected $limit;

    /**
     * The repository being used to store events
     * @var EventRepositoryInterface
     */
    protected $repository;

    /**
     * Create a new rate limiter
     * @param EventInterface           $event
     * @param RateLimitInterface       $limit
     * @param EventRepositoryInterface $repository
     */
    public function __construct(
        EventInterface $event,
        RateLimitInterface $limit,
        EventRepositoryInterface $repository
    ) {
        $this->event = $event;
        $this->limit = $limit;
        $this->repository = $repository;
    }

    /**
     * Checks if this rate limiter passes the rate limit
     * @return void
     */
    public function run()
    {
        // If the user is penalized then penalize the actor for trying again
        if ($this->isPenalized()->toBool()) {
            $this->penalize();
        }

        // Cleanse the repository of old events
        $this->repository->cleanse($this->event, $this->getSince());

        // If this event would exceed the rate limit then penalize the actor
        if ($this->exceedsRateLimit()->toBool()) {
            $this->penalize();
        }

        // Add the new event to the repository
        $this->repository->add($this->event);
    }

    /**
     * Get the number of remaining attempts
     * @return IntegerInterface
     */
    public function getRemaining() : IntegerInterface
    {
        $count = $this->repository->count($this->event);

        return new Integer(max($count, 0));
    }

    /**
     * Checks if the actor has been penalized
     * @return Boolean
     */
    public function isPenalized() : Boolean
    {
        $last = $this->repository->last($this->event);

        if (!$last) {
            return new Boolean(false);
        }

        return new Boolean(
            $last->timeBetween(new Timestamp(time()))->toInt() > 0
        );
    }

    /**
     * Get the timeout for an imposed penalty
     * @return IntegerInterface
     */
    public function getTimeout() : IntegerInterface
    {
        $last = $this->repository->last($this->event);

        if (!$last) {
            return new Integer(0);
        }

        return new Integer($last->timeBetween(new Timestamp(time())));
    }

    /**
     * Penalizes the actor for hitting the rate limit
     * @return void
     */
    protected function penalize()
    {
        // Get the last occuring matching event
        $last = $this->repository->last($this->event);

        // Remove all events
        $this->repository->cleanse($this->event, new Timestamp(time()));

        // Create a new future penalty event
        $penalty = new Event(
            $last->getName(),
            $this->event->getCost(),
            $last->getTimestamp()->add($this->limit->getPenalty()),
            $this->event->getActor()
        );

        // Add the new event to the repository
        $this->repository->add($this->event);

        throw new RateLimitExceededException('Rate limit has been exceeded');
    }

    /**
     * Checks if adding the event would cause the rate limit to be exceeded
     * @return Boolean
     */
    protected function exceedsRateLimit() : Boolean
    {
        $count = $this->repository->count($this->event);
        $cost = $this->event->getCost();
        $limit = $this->limit->getLimit();

        return $count->add($cost)->greaterThan($limit);
    }

    /**
     * Gets the timestamp all events should be considered for rate limiting since
     * @return Timestamp
     */
    abstract protected function getSince() : Timestamp;
}
