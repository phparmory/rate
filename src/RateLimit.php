<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\RateLimitInterface,
    Contracts\IntegerInterface
};

final class RateLimit implements RateLimitInterface
{
    /**
     * The number of allowed attempts for this rate limit
     * @var IntegerInterface $limit
     */
    private $limit;

    /**
     * The timeframe for this rate limit in seconds
     * @var IntegerInterface
     */
    private $timeframe;

    /**
     * The penalty for hitting the limit
     * @var IntegerInterface
     */
    private $penalty;

    /**
     * Create a new rate limit
     * @param IntegerInterface $limit
     * @param IntegerInterface $timeframe
     * @param IntegerInterface $penalty
     * @return void
     */
    public function __construct(IntegerInterface $limit, IntegerInterface $timeframe, IntegerInterface $penalty)
    {
        $this->limit = $limit;
        $this->timeframe = $timeframe;
        $this->penalty = $penalty;
    }

    /**
     * Get the number of allowed attempts for this rate limit
     * @return IntegerInterface
     */
    public function getLimit() : IntegerInterface
    {
        return $this->limit;
    }

    /**
     * Get the timeframe for this rate limit
     * @return IntegerInterface
     */
    public function getTimeframe() : IntegerInterface
    {
        return $this->timeframe;
    }

    /**
     * Get the penalty for hitting the limit
     * @return IntegerInterface
     */
    public function getPenalty() : IntegerInterface
    {
        return $this->penalty;
    }
}
