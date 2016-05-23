<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\IntegerInterface
};

interface RateLimitInterface
{
    /**
     * Get the number of allowed attempts for this rate limit
     * @return IntegerInterface
     */
    public function getLimit() : IntegerInterface;

    /**
     * Get the timeframe for this rate limit
     * @return IntegerInterface
     */
    public function getTimeframe() : IntegerInterface;

    /**
     * Get the penalty for hitting the limit
     * @return IntegerInterface
     */
    public function getPenalty() : IntegerInterface;
}
