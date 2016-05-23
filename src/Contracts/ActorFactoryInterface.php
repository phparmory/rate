<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Contracts\ActorInterface
};

interface ActorFactoryInterface
{
    /**
     * Makes a new actor
     * @param string $ip
     * @return ActorInterface
     */
    public function create($ip) : ActorInterface;
}
