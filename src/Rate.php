<?php

namespace Armory\Rate;

use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RepositoryInterface;
use Armory\Rate\Contracts\StrategyInterface;
use Armory\Rate\Strategies\BasicStrategy;
use Armory\Rate\Strategies\DynamicStrategy;
use RuntimeException;

class Rate
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
     * Create a new rate limiter
     * @param RepositoryInterface $repository
     */
    function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Sets the strategy for this rate limiter
     * @param StrategyInterface $strategy
     * @return void
     */
    public function strategy(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;

        return $this;
    }

    /**
     * Sets the strategy of this rate limiter to dynamic
     * @return void
     */
    public function dynamic()
    {
        $this->strategy(new DynamicStrategy($this->repository));

        return $this;
    }

    /**
     * Sets the strategy of this rate limiter to basic
     * @return void
     */
    public function basic()
    {
        $this->strategy(new BasicStrategy($this->repository));

        return $this;
    }

    /**
     * Set the timeframe in seconds
     * @param int $seconds
     * @return Rate
     */
    public function seconds($seconds)
    {
        if (!$this->strategy) {
            throw new RuntimeException('No strategy has been set for this rate limiter');
        }

        $this->strategy->setTimeframe($seconds);

        return $this;
    }

    /**
     * Set the timeframe in minutes
     * @param int $minutes
     * @return Rate
     */
    public function minutes($minutes)
    {
        $this->seconds($minutes * 60);

        return $this;
    }

    /**
     * Set the timeframe in hours
     * @param int $hours
     * @return Rate
     */
    public function hours($hours)
    {
        $this->minutes($hours * 60);

        return $this;
    }

    /**
     * Limit the number of attempts
     * @param int $limit
     * @return Rate
     */
    public function limit($limit)
    {
        if (!$this->strategy) {
            throw new RuntimeException('No strategy has been set for this rate limiter');
        }

        $this->strategy->setAllow($limit);

        return $this;
    }

    /**
     * Sets the event to fire
     * @param  EventInterface $event
     * @return Rate
     */
    public function fire(EventInterface $event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Handles the event firing as an actor
     * @param  ActorInterface $actor
     * @throws RateLimitExceededException
     * @return
     */
    public function as(ActorInterface $actor)
    {
        if (!$this->strategy) {
            throw new RuntimeException('No strategy has been set for this rate limiter');
        }

        $this->strategy->handle($actor, $this->event);

        unset($this->event);
    }
}
