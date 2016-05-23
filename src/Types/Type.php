<?php

namespace Armory\Rate\Types;

abstract class Type
{
    /**
     * The value of the this type
     * @var int
     */
    protected $value;

    /**
     * Get the int value of this type
     * @return int
     */
    public function toInt() : int
    {
        return intval($this->value);
    }

    /**
     * Get the bool value of this type
     * @return bool
     */
    public function toBool() : bool
    {
        return boolval($this->value);
    }

    /**
     * Get the literal string value of this type
     * @return string
     */
    public function toString() : string
    {
        return strval($this->value);
    }

    /**
     * Get the literal string value of this type
     * @return string
     */
    public function __toString() : string
    {
        return $this->toString();
    }
}
