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
    protected $events;

    /**
     * Prepares the repository to filter by event
     * @param EventInterface $event
     * @return RepositoryInterface
     */
    public function for(EventInterface $event)
    {
        $this->event = $event;

        return $this;
    }
}
