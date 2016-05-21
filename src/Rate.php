<?php

namespace Armory\Rate;

use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RateInterface;
use Armory\Rate\Contracts\RepositoryInterface;
use Armory\Rate\Contracts\StrategyInterface;
use Armory\Rate\Strategies\BasicStrategy;
use Armory\Rate\Strategies\DynamicStrategy;
use RuntimeException;

class Rate implements RateInterface
{
    /**
     * The strategy to use for rate limiting
     * @var StrategyInterface
     */
    protected $strategy;

    /**
     * The event to fire
     * @var EventInterface
     */
    protected $event;

    /**
     * The repository to store events in
     * @var RepositoryInterface
     */
    protected $repository;

    /**
     * Gets the strategy for this rate limiter
     * @return StrategyInterface
     */
    public function getStrategy()
    {
        // Default to a basic strategy
        if (!$this->strategy) {
            $this->setStrategy(new BasicStrategy($this->getRepository()));
        }

        return $this->strategy;
    }

    /**
     * Sets the strategy for this rate limiter
     * @param StrategyInterface $strategy
     * @return RateInterface
     */
    public function setStrategy(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * Gets the repository for this rate limiter
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        if (!$this->repository) {
            $this->setRepository(new MemoryRepository);
        }

        return $this->repository;
    }

    /**
     * Sets the repository for this rate limiter
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Sets the strategy of this rate limiter to dynamic
     * @return RateInterface
     */
    public function dynamic()
    {
        $this->setStrategy(new DynamicStrategy($this->getRepository()));

        return $this;
    }

    /**
     * Set the timeframe in seconds
     * @param int $seconds
     * @return RateInterface
     */
    public function seconds($seconds)
    {
        $this->getStrategy()->setTimeframe($seconds);

        return $this;
    }

    /**
     * Set the timeframe in minutes
     * @param int $minutes
     * @return RateInterface
     */
    public function minutes($minutes)
    {
        $this->seconds($minutes * 60);

        return $this;
    }

    /**
     * Set the timeframe in hours
     * @param int $hours
     * @return RateInterface
     */
    public function hours($hours)
    {
        $this->minutes($hours * 60);

        return $this;
    }

    /**
     * Limit the number of attempts to allow
     * @param int $limit
     * @return RateInterface
     */
    public function allow($limit)
    {
        $this->getStrategy()->setAllow($limit);

        return $this;
    }

    /**
     * Sets the event to handle
     * @param  EventInterface $event
     * @return RateInterface
     */
    public function handle(EventInterface $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Handles the event firing as an actor
     * @param  ActorInterface $actor
     * @throws RateLimitExceededException
     * @return void
     */
    public function as(ActorInterface $actor)
    {
        $this->getStrategy()->handle($actor, $this->event);

        unset($this->event);
    }

    /**
     * Gets the number of remaining attempts available
     * @return int
     */
    public function remaining(ActorInterface $actor, EventInterface $event)
    {
        return $this->getStrategy()->getRemaining($actor, $event);
    }
}
