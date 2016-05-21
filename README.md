# Rate
Rate limiter implementation

### Actors

Actors are an abstract class that are able to fire events:

```php
use Armory\Rate\Actors\Actor;

class TestActor extends Actor
{
    protected $id = 1;
}
```

### Events

Events are the class that get rate limited:

```php
use Armory\Rate\Events\Event;

class TestEvent extends Event
{
    protected $id = 1;
}
```

### Repositories

Repositories can allow for events to be persisted across requests when they're fired. Rate comes with
an in-memory repository that gets you started.

### Strategies

A strategy determines how rate limiting is performed. The two main strategies are:

- BasicStrategy e.g. 60 requests every hour
- DynamicStrategy (leaky bucket) e.g. 60 requests within an hour

With the basic strategy if 60 requests are performed in the first minute, you would
have to wait 59 minutes until the hour is up before firing another event.

With the dynamic strategy if 60 requests are performed in the first minute, you would
be able to fire another event in 1 minute.

```php
use Armory\Rate\Strategies\BasicStrategy;
use Armory\Rate\Repositories\MemoryRepository;

$strategy = new BasicStrategy(new MemoryRepository);
$strategy->setAllow(1); // 1 request
$strategy->setTimeframe(1); // every second

$actor = new TestActor;
$event = new TestEvent;

$strategy->handle($actor, $event); // Works
$strategy->handle($actor, $event); // Throws RateLimitExceededException
```

### Rate limiters

Rate comes with a more expressive way of creating rate limiters:

```php
use Armory\Rate\Rate;

// Uses a dynamic strategy and memory repository allowing 2 events within 3 seconds
$rate = new Rate()->dynamic()->allow(2)->seconds(3);

$rate->handle(new TestEvent)->as($actor);
$rate->handle(new TestEvent)->as($actor);
$rate->handle(new TestEvent)->as($actor);
```

