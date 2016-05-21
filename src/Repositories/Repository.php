<?php

namespace Armory\Rate\Repositories;

use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{
    /**
     * The event to filter by
     * @var EventInterface
     */
    protected $filter;

    /**
     * Prepares the repository to filter by event
     * @return EventInterface $event
     */
    public function filter(EventInterface $event)
    {
        $this->filter = $event;

        return $this;
    }
}
