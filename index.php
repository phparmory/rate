<?php

require 'vendor/autoload.php';

use Armory\Rate\Actors\Actor;
use Armory\Rate\Events\Event;
use Armory\Rate\Exceptions\RateLimitExceededException;
use Armory\Rate\Repositories\MemoryRepository;
use Armory\Rate\Strategies\DynamicStrategy;
use Armory\Rate\Strategies\StaticStrategy;

class TestActor extends Actor
{
    protected $id = 1;
}

class TestEvent extends Event
{
    protected $id = 'test.event';

    protected $cost = 1;
}

$actor = new TestActor;

$repository = new MemoryRepository;

$rate = new StaticStrategy($repository);
$rate->setAllow(2);
$rate->setTimeframe(3);

$rate->handle($actor, new TestEvent);
sleep(1);
$rate->handle($actor, new TestEvent);
sleep(1);
$rate->handle($actor, new TestEvent);

var_dump($repository->all());
