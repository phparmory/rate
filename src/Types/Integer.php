<?php

namespace Armory\Rate\Types;

use Assert\Assertion;
use Armory\Rate\{
    Contracts\TypeInterface,
    Contracts\IntegerInterface,
    Types\Boolean
};

class Integer extends Type implements TypeInterface, IntegerInterface
{
    /**
     * Create a new value object
     * @param int $value
     * @return void
     */
    public function __construct($value)
    {
        Assertion::integer($value);

        $this->value = $value;
    }

    /**
     * Checks if this type is greater than another type
     * @param  TypeInterface $type
     * @return bool
     */
    public function greaterThan(TypeInterface $type) : Boolean
    {
        return new Boolean($this->toInt() > $type->toInt());
    }

    /**
     * Checks if this type is less than another type
     * @param  TypeInterface $type
     * @return bool
     */
    public function lessThan(TypeInterface $type) : Boolean
    {
        return new Boolean($this->toInt() < $type->toInt());
    }

    /**
     * Adds two types together and returns a new integer
     * @param TypeInterface $type
     */
    public function add(TypeInterface $type) : TypeInterface
    {
        return new static($this->toInt() + $type->toInt());
    }
}
