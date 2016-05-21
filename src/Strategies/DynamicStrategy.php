<?php

namespace Armory\Rate\Strategies;

/**
 * The dynamic strategy implements a leaky bucket rate limiter i.e.
 * allow X events within Y minutes.
 */
class DynamicStrategy extends Strategy
{
    /**
     * Gets the timestamp after which events should be considered for rate limiting
     * @param int $id
     * @return int
     */
    public function getSince($id)
    {
        return time() - $this->getTimeframe();
    }
}
