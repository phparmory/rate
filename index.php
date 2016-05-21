<?php

require 'vendor/autoload.php';

use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Exceptions\RateLimitExceededException;
use Armory\Rate\Rate;
use Armory\Rate\Repositories\MemoryRepository;
use Armory\Rate\Repositories\RedisRepository;
use Armory\Rate\Traits\RateLimitActor;
use Armory\Rate\Traits\RateLimitEvent;
use Predis\Client;

class RequestApi implements EventInterface
{
    use RateLimitEvent;
}

class User implements ActorInterface
{
    use RateLimitActor;
}

$request = new RequestApi;
$user = new User;
$rate = new Rate;
$repository = new RedisRepository(new Client);

$rate->setRepository($repository);

$rate->dynamic()->allow(5)->seconds(10);

try {
    $rate->handle($request)->as($user);
} catch (RateLimitExceededException $e) {
    var_dump('Rate limit exceeded. ' . $rate->remaining($user, $request) . ' remaining.');
}
