<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Types\Integer
};

interface RateLimitInterface
{
    /**
     * Get the number of allowed attempts for this rate limit
     * @return Integer
     */
    public function getLimit() : Integer;

    /**
     * Get the timeframe for this rate limit
     * @return Integer
     */
    public function getTimeframe() : Integer;

    /**
     * Get the penalty for hitting the limit
     * @return Integer
     */
    public function getPenalty() : Integer;
}
