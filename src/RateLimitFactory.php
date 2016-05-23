<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\RateLimitFactoryInterface,
    Contracts\RateLimitInterface,
    RateLimit,
    Types\Integer
};

class RateLimitFactory implements RateLimitFactoryInterface
{
    /**
     * Makes a new rate limit
     * @param int $limit
     * @param int $timeframe
     * @param int $penalty
     * @return RateLimit
     */
    public function create($limit, $timeframe, $penalty) : RateLimitInterface
    {
        return new RateLimit(
            new Integer($limit),
            new Integer($timeframe),
            new Integer($penalty)
        );
    }
}
