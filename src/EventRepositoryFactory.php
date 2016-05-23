<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\EventRepositoryFactoryInterface,
    Contracts\EventRepositoryInterface,
    Repositories\FakeEventRepository,
    Types\EventCollection
};

class EventRepositoryFactory implements EventRepositoryFactoryInterface
{
    /**
     * Make a new fake repository
     * @return EventRepositoryInterface
     */
    public function create() : EventRepositoryInterface
    {
        return new FakeEventRepository(new EventCollection([]));
    }
}
