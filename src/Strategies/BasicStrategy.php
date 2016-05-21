<?php

namespace Armory\Rate\Strategies;

/**
 * The basic strategy specifies a rate limit within a fixed time
 * frame i.e. allow X events every Y minutes.
 */
class BasicStrategy extends Strategy
{
    /**
     * Gets the timestamp after which events should be considered for rate limiting
     * @param int $id
     * @return int
     */
    public function getSince($id)
    {
        $min = $this->repository->first($id) - 1;
        $max = $min + $this->getTimeframe() + 1;
        return time() > $max ? $max : $min;
    }
}
