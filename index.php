<?php

require 'vendor/autoload.php';

use Armory\Rate\{
    ActorFactory,
    EventFactory,
    EventRepositoryFactory,
    RateLimitFactory,
    RateLimiterFactory
};

$actorFactory = new ActorFactory;
$eventFactory = new EventFactory;
$eventRepositoryFactory = new EventRepositoryFactory;
$rateLimitFactory = new RateLimitFactory;
$rateLimiterFactory = new RateLimiterFactory;

$actor = $actorFactory->create('127.0.0.1');
$event = $eventFactory->create('api.request', 1, $actor);
$repository = $eventRepositoryFactory->create();
$rateLimit = $rateLimitFactory->create(1, 5, 0);
$rateLimiter = $rateLimiterFactory->create($event, $rateLimit, $repository);

$rateLimiter->run();
$rateLimiter->run();
