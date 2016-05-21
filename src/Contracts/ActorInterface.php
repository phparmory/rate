<?php

namespace Armory\Rate\Contracts;

interface ActorInterface
{
    /**
     * Returns the unique identifier for this actor
     * @return string
     */
    public function getIdentifier();
}
