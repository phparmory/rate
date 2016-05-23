<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface,
    Contracts\EventRepositoryInterface,
    Contracts\RateLimitInterface,
    Contracts\RateLimiterInterface
};

interface RateLimiterFactoryInterface
{
    /**
     * Make a basic strategy
     * @param EventInterface $event
     * @param RateLimitInterface $limit
     * @param EventRepositoryInterface $repository
     * @return RateLimiterInterface
     */
    public function create(
        EventInterface $event,
        RateLimitInterface $limit,
        EventRepositoryInterface $repository
    ) : RateLimiterInterface;

    /**
     * Make a dynamic strategy
     * @param EventInterface $event
     * @param RateLimitInterface $limit
     * @param EventRepositoryInterface $repository
     * @return RateLimiterInterface
     */
    public function dynamic(
        EventInterface $event,
        RateLimitInterface $limit,
        EventRepositoryInterface $repository
    ) : RateLimiterInterface;
}
