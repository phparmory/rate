<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\ActorInterface,
    Contracts\EventInterface
};

interface RateLimitFactoryInterface
{
    /**
     * Makes a new rate limit
     * @param int $limit
     * @param int $timeframe
     * @param int $penalty
     * @return RateLimit
     */
    public function create($limit, $timeframe, $penalty) : RateLimitInterface;
}
