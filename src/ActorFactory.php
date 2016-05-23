<?php

namespace Armory\Rate;

use Armory\Rate\{
    Actor,
    Contracts\ActorFactoryInterface,
    Contracts\ActorInterface,
    Types\IpAddress
};

class ActorFactory implements ActorFactoryInterface
{
    /**
     * Makes a new actor
     * @param string $ip
     * @return ActorInterface
     */
    public function create($ip) : ActorInterface
    {
        return new Actor(new IpAddress($ip));
    }
}
