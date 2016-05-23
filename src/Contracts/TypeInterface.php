<?php

namespace Armory\Rate\Contracts;

interface TypeInterface
{
    /**
     * Get the int value of this type
     * @return int
     */
    public function toInt() : int;

    /**
     * Get the bool value of this type
     * @return bool
     */
    public function toBool() : bool;

    /**
     * Get the literal string value of this type
     * @return string
     */
    public function toString() : string;

    /**
     * Get the literal string value of this type
     * @return string
     */
    public function __toString() : string;
}
