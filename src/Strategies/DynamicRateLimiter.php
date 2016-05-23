<?php

namespace Armory\Rate\Strategies;

use Armory\Rate\{
    Contracts\RateLimiterInterface,
    RateLimiter,
    Types\Timestamp
};

/**
 * The dynamic strategy implements a leaky bucket rate limiter i.e.
 * allow X events within Y minutes.
 */
class DynamicRateLimiter extends RateLimiter implements RateLimiterInterface
{
    /**
     * Gets the timestamp after which events should be considered for rate limiting
     * @return int
     */
    protected function getSince() : Timestamp
    {
        return new Timestamp(time() - $this->limit->getTimeframe()->toInt());
    }
}
