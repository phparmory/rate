<?php

namespace Armory\Rate\Types;

use Armory\Rate\{
    Contracts\TypeInterface
};

final class IpAddress extends Type implements TypeInterface
{
    /**
     * Create a new IP address value object
     * @param string $value
     * @return void
     */
    public function __construct($value)
    {
        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new InvalidArgumentException;
        }

        $this->value = $value;
    }
}
