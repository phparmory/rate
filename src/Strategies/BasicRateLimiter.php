<?php

namespace Armory\Rate\Strategies;

use Armory\Rate\{
    Contracts\RateLimiterInterface,
    RateLimiter,
    Types\Timestamp
};

/**
 * The basic strategy specifies a rate limit within a fixed time
 * frame i.e. allow X events every Y minutes.
 */
class BasicRateLimiter extends RateLimiter implements RateLimiterInterface
{
    /**
     * Gets the timestamp after which events should be considered for rate limiting
     * @return Timestamp
     */
    public function getSince() : Timestamp
    {
        // Get the first occuring matching event
        $first = $this->repository->first($this->event);

        // If there are no events then just use the current time
        if (!$first) {
            return new Timestamp(time());
        }

        // Get the minimum and max timestamps
        $min = $first->getTimestamp()->toInt() - 1;
        $max = $min + $this->limit->getTimeframe()->toInt() + 1;

        // If now is more recent than the last valid timestamp
        // then now can be considered the new start
        return time() > $max ? new Timestamp(time()) : new Timestamp($min);
    }
}
