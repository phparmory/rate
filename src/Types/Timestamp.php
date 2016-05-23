<?php

namespace Armory\Rate\Types;

use Assert\Assertion;
use Armory\Rate\{
    Contracts\TypeInterface,
    Types\Integer
};

final class Timestamp extends Integer implements TypeInterface
{
    /**
     * Compares this timestamp with another
     * @param  Timestamp $timestamp
     * @return Integer
     */
    public function compare(Timestamp $timestamp)
    {
        return new Integer($this->toNative() <=> $timestamp->toNative());
    }
}
