<?php

namespace Armory\Rate\Types;

use Assert\Assertion;
use Armory\Rate\{
    Contracts\TypeInterface
};

class Boolean extends Type implements TypeInterface
{
    /**
     * Create a new value object
     * @param bool $value
     * @return void
     */
    public function __construct($value)
    {
        Assertion::boolean($value);

        $this->value = $value;
    }
}
