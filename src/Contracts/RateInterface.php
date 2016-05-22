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
     * Set a penalty for getting rate limited in seconds
     * @param int $penalty
     * @return RateInterface
     */
    public function penalty($penalty);

    /**
     * Sets the event to handle
     * @param string $event
     * @param int $cost
     * @return RateInterface
     */
    public function handle(string $event, $cost = 1);

    /**
     * Handles the event firing as an actor
     * @param string $actor
     * @throws RateLimitExceededException
     * @return void
     */
    public function as(string $actor);

    /**
     * Gets the number of remaining attempts available
     * @param string $actor
     * @param string $event
     * @return int
     */
    public function getRemaining(string $actor, string $event);

    /**
     * Gets the penalty timeout in seconds from now
     * @param string $actor
     * @param string $event
     * @return int
     */
    public function getTimeout(string $actor, string $event);
}
