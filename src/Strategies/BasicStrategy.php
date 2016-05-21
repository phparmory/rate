<?php

namespace Armory\Rate\Strategies;

use Armory\Rate\Contracts\EventInterface;

/**
 * The basic strategy specifies a rate limit within a fixed time
 * frame i.e. allow X events every Y minutes.
 */
class BasicStrategy extends Strategy
{
    /**
     * Gets the timestamp before which events are counted for rate limiting
     * @param string $id
     * @return int
     */
    public function getBefore($id)
    {
        return $this->getAfter($id) + $this->getTimeframe() + 1;
    }

    /**
     * Gets the timestamp after which events are counted for rate limiting
     * @param string $id
     * @return int
     */
    public function getAfter($id)
    {
        return $this->repository->first($id) - 1;
    }

    /**
     * Gets the timestamp before which events should be garbage collected
     * @param int $after
     * @param int $before
     * @return int
     */
    public function getTrashBefore($after, $before)
    {
        return time() > $before ? $before : $after;
    }
}
