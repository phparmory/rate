<?php

namespace Armory\Rate;

use Armory\Rate\{
    Contracts\ActorInterface,
    Types\IpAddress
};

final class Actor implements ActorInterface
{
    /**
     * The unique identifier for this
     * @var IpAddress
     */
    private $ip;

    /**
     * Create a new actor
     * @param IpAddress $ip
     * @return void
     */
    public function __construct(IpAddress $ip)
    {
        $this->ip = $ip;
    }

    /**
     * Get the IP address of this actor
     * @return IpAddress
     */
    public function getIp() : IpAddress
    {
        return $this->ip;
    }
}
