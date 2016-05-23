<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\EventInterface,
    Contracts\EventRepositoryInterface,
    Contracts\RateLimitInterface,
    Contracts\RateLimiterFactoryInterface,
    Contracts\RateLimiterInterface,
    Strategies\BasicRateLimiter,
    Strategies\DynamicRateLimiter
};

class RateLimiterFactory implements RateLimiterFactoryInterface
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
    ) : RateLimiterInterface {
        return new BasicRateLimiter($event, $limit, $repository);
    }

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
    ) : RateLimiterInterface {
        return new DynamicRateLimiter($event, $limit, $repository);
    }
}
