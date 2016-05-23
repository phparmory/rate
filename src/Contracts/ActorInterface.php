<?php

namespace Armory\Rate\Contracts;

use Armory\Rate\{
    Types\IpAddress
};

interface ActorInterface
{
    /**
     * Get the IP address of this actor
     * @return IpAddress
     */
    public function getIp() : IpAddress;
}
