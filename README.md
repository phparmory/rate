# Rate
Rate limiter implementation

### Actors

Actors are an abstract class that are able to fire events:

```php
use Armory\Rate\Contracts\ActorInterface;
use Armory\Rate\Traits\RateLimitActor;

class User implements ActorInterface
{
    use RateLimitActor;

    protected $actorId = 1;
}
```

### Events

Events are classes that can be rate limited:

```php
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Traits\RateLimitEvent;

class RequestsApi implements EventInterface
{
    use RateLimitEvent;

    protected $eventId = 1;
}
```

### Repositories

Repositories store collections of events that have been fired. The MemoryRepository
is a good place to start:

```php
use Armory\Rate\Repositories\MemoryRepository;

$repository = new MemoryRepository;
$user = new User;
$request = new RequestsApi;

// Form a unique ID with the actorId and eventId
$id = $user->getUserId() . ':' . $request->getEventId();

$repository->add($id, $request);

echo $repository->count($id); // 1
```

### Strategies

A strategy determines how rate limiting is performed. The two main strategies are:

- BasicStrategy e.g. 60 requests every hour
- DynamicStrategy (leaky bucket) e.g. 60 requests within an hour

```php
use Armory\Rate\Strategies\BasicStrategy;
use Armory\Rate\Repositories\MemoryRepository;

$strategy = new BasicStrategy(new MemoryRepository);
$strategy->setAllow(1); // 1 request
$strategy->setTimeframe(1); // every second

$user = new User;
$request = new RequestApi;

$strategy->handle($user, $request); // Works
$strategy->handle($user, $request); // Throws RateLimitExceededException
```

### Rate limiters

Rate comes with a more expressive way of creating rate limiters:

```php
use Armory\Rate\Rate;

// Uses a dynamic strategy and memory repository allowing 2 events within 3 seconds
$rate = new Rate()->dynamic()->allow(2)->seconds(3);

$rate->handle(new TestEvent)->as($actor);
$rate->handle(new TestEvent)->as($actor);
$rate->handle(new TestEvent)->as($actor); // Throws RateLimitExceededException
```

### Costs

If you have multiple events that need rate limiting then one approach would be to
create new rate limiters for each endpoint like so:

```php
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Traits\RateLimitEvent;
use Rate;

class RequestsUserApi implements EventInterface
{
    use RateLimitEvent;

    protected $eventId = 1;
}

class RequestsPostsApi implements EventInterface
{
    use RateLimitEvent;

    protected $eventId = 2;
}

$userApi = new Rate;
$userApi->allow(100)->hour(1); // Allow 100 requests to the user api an hour

$postsApi = new Rate;
$postsApi->allow(50)->hour(1); // Allow 50 requests to the posts api an hour
```

This would allow the user a total of 150 requests per hour, 100 for the user api
and 50 for the posts api. Another way to handle it is using costs:

```php
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Traits\RateLimitEvent;
use Rate;

class RequestsUserApi implements EventInterface
{
    use RateLimitEvent;

    protected $eventId = 1;

    protected $cost = 1;
}

class RequestsPostsApi implements EventInterface
{
    use RateLimitEvent;

    protected $eventId = 2;

    protected $cost = 2;
}

$api = new Rate;
$api->allow(200)->hour(1); // User has 200 api credits per hour
```

In this case the user has 200 api credits to use. They could do:

- 200 requests to the user api or
- 100 requests to the posts api or
- 100 requests so the user api and 50 to the posts api
