<?php

namespace Armory\Rate;

use Armory\Rate\{
    Types\IpAddress
};

class NulLActor implements ActorInterface
{
    /**
     * Get the IP address of this actor
     * @return IpAddress
     */
    public function getIp() : IpAddress
    {
        return new IpAddress('0.0.0.0');
    }
}
