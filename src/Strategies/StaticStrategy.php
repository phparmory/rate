<?php

namespace Armory\Rate\Strategies;

use Armory\Rate\Contracts\EventInterface;

/**
 * The static strategy specifies a rate limit within a fixed time
 * frame i.e. allow X events every Y minutes.
 */
class StaticStrategy extends Strategy
{
    /**
     * Gets the timestamp before which events are counted for rate limiting
     * @param EventInterface $event
     * @return int
     */
    public function getBefore(EventInterface $event)
    {
        return $this->getAfter($event) + $this->getTimeframe();
    }

    /**
     * Gets the timestamp after which events are counted for rate limiting
     * @return int
     */
    public function getAfter(EventInterface $event)
    {
        return $this->repository->first($event);
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
