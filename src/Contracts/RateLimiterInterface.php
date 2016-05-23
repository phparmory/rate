<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Types\Boolean,
    Types\Integer
};

interface RateLimiterInterface
{
    /**
     * Checks if this rate limiter passes the rate limit
     * @return void
     */
    public function run();

    /**
     * Get the number of remaining
     * @return Integer
     */
    public function getRemaining() : Integer;

    /**
     * Checks if the actor has been penalized
     * @return Boolean
     */
    public function isPenalized() : Boolean;

    /**
     * Get the timeout for an imposed penalty
     * @return Integer
     */
    public function getTimeout() : Integer;
}
