<?php

namespace Armory\Rate\Types;

use Assert\Assertion;
use Armory\Rate\{
    Contracts\TypeInterface
};

class StringLiteral extends Type implements TypeInterface
{
    /**
     * Create a new name value object
     * @param string $value
     * @return void
     */
    public function __construct($value)
    {
        Assertion::string($value);

        $this->value = $value;
    }
}
