<?php

namespace Armory\Rate\Contracts;

use Assert\Assertion;
use Armory\Rate\{
    Contracts\TypeInterface,
    Types\Boolean
};

interface IntegerInterface
{
    /**
     * Checks if this type is greater than another type
     * @param  TypeInterface $type
     * @return bool
     */
    public function greaterThan(TypeInterface $type) : Boolean;

    /**
     * Checks if this type is less than another type
     * @param  TypeInterface $type
     * @return bool
     */
    public function lessThan(TypeInterface $type) : Boolean;

    /**
     * Adds two types together and returns a new integer
     * @param TypeInterface $type
     */
    public function add(TypeInterface $type) : TypeInterface;
}
