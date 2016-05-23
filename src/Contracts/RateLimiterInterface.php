<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Types\Boolean,
    Contracts\IntegerInterface
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
     * @return IntegerInterface
     */
    public function getRemaining() : IntegerInterface;

    /**
     * Checks if the actor has been penalized
     * @return Boolean
     */
    public function isPenalized() : Boolean;

    /**
     * Get the timeout for an imposed penalty
     * @return IntegerInterface
     */
    public function getTimeout() : IntegerInterface;
}
