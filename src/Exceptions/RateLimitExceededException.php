<?php

namespace Armory\Rate\Exceptions;

use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Contracts\StrategyInterface;
use RuntimeException;

class RateLimitExceededException extends RuntimeException
{
}
