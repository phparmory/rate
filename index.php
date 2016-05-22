<?php

require 'vendor/autoload.php';

use Armory\Rate\Exceptions\RateLimitExceededException;
use Armory\Rate\Exceptions\RateLimitPenaltyException;
use Armory\Rate\Rate;
use Armory\Rate\Repositories\RedisRepository;
use Predis\Client;

$rate = new Rate;
$repository = new RedisRepository(new Client);
$rate->setRepository($repository);

$rate->dynamic()
    ->allow(3)
    ->seconds(10)
    ->penalty(5);

$request = 'api.request';
$user = 'Richard Crosby';

try {
    $rate->handle($request)->as($user);
    var_dump('Succeeded. ' . $rate->getRemaining($user, $request) . ' remaining.');
} catch (RateLimitExceededException $e) {
    var_dump('Rate limit exceeded. ' . $rate->getRemaining($user, $request) . ' remaining.');
} catch (RateLimitPenaltyException $e) {
    var_dump('Rate limit penalty. Available ' . $rate->getTimeout($user, $request) . ' seconds from now.');
}
