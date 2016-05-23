<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\RateLimitInterface,
    Types\Integer
};

final class RateLimit implements RateLimitInterface
{
    /**
     * The number of allowed attempts for this rate limit
     * @var Integer $limit
     */
    private $limit;

    /**
     * The timeframe for this rate limit in seconds
     * @var Integer
     */
    private $timeframe;

    /**
     * The penalty for hitting the limit
     * @var Integer
     */
    private $penalty;

    /**
     * Create a new rate limit
     * @param Integer $limit
     * @param Integer $timeframe
     * @param Integer $penalty
     * @return void
     */
    public function __construct(Integer $limit, Integer $timeframe, Integer $penalty)
    {
        $this->limit = $limit;
        $this->timeframe = $timeframe;
        $this->penalty = $penalty;
    }

    /**
     * Get the number of allowed attempts for this rate limit
     * @return Integer
     */
    public function getLimit() : Integer
    {
        return $this->limit;
    }

    /**
     * Get the timeframe for this rate limit
     * @return Integer
     */
    public function getTimeframe() : Integer
    {
        return $this->timeframe;
    }

    /**
     * Get the penalty for hitting the limit
     * @return Integer
     */
    public function getPenalty() : Integer
    {
        return $this->penalty;
    }
}
