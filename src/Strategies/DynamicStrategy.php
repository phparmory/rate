<?php

namespace Armory\Rate\Strategies;

use Armory\Rate\Contracts\EventInterface;

/**
 * The dynamic strategy implements a leaky bucket rate limiter i.e.
 * allow X events within Y minutes.
 */
class DynamicStrategy extends Strategy
{
    /**
     * Gets the timestamp before which events are counted for rate limiting
     * @param string $id
     * @return int
     */
    public function getBefore($id)
    {
        return time() + 1;
    }

    /**
     * Gets the timestamp after which events are counted for rate limiting
     * @param string $id
     * @return int
     */
    public function getAfter($id)
    {
        return time() - $this->getTimeframe();
    }

    /**
     * Gets the timestamp before which events should be garbage collected
     * @param int $after
     * @param int $before
     * @return int
     */
    public function getTrashBefore($after, $before)
    {
        return $after;
    }
}
