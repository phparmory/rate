<?php

namespace Armory\Rate\Contracts;

interface RateInterface
{
    /**
     * Gets the strategy for this rate limiter
     * @return StrategyInterface
     */
    public function getStrategy();

    /**
     * Sets the strategy for this rate limiter
     * @param StrategyInterface $strategy
     * @return RateInterface
     */
    public function setStrategy(StrategyInterface $strategy);

    /**
     * Gets the repository for this rate limiter
     * @return RepositoryInterface
     */
    public function getRepository();

    /**
     * Sets the repository for this rate limiter
     * @param RepositoryInterface $repository
     */
    public function setRepository(RepositoryInterface $repository);

    /**
     * Sets the strategy of this rate limiter to dynamic
     * @return RateInterface
     */
    public function dynamic();

    /**
     * Set the timeframe in seconds
     * @param int $seconds
     * @return RateInterface
     */
    public function seconds($seconds);

    /**
     * Set the timeframe in minutes
     * @param int $minutes
     * @return RateInterface
     */
    public function minutes($minutes);

    /**
     * Set the timeframe in hours
     * @param int $hours
     * @return RateInterface
     */
    public function hours($hours);

    /**
     * Limit the number of attempts to allow
     * @param int $limit
     * @return RateInterface
     */
    public function allow($limit);

    /**
     * Sets the event to handle
     * @param  EventInterface $event
     * @return RateInterface
     */
    public function handle(EventInterface $event);

    /**
     * Handles the event firing as an actor
     * @param  ActorInterface $actor
     * @throws RateLimitExceededException
     * @return void
     */
    public function as(ActorInterface $actor);

    /**
     * Gets the number of remaining attempts available
     * @return int
     */
    public function remaining(ActorInterface $actor, EventInterface $event);
}
