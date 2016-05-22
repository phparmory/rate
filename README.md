# Rate
Rate limiter implementation

### Actors

Actors are the class that can fire events:

```php
use Armory\Rate\Actors\Actor;

class User extends Actor
{
}
```

### Events

Events are classes that can be rate limited:

```php
use Armory\Rate\Events\Event;

class RequestsApi extends Event
{
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

Rate comes with a RedisRepository and LaravelRepository as well.

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
$request = new RequestsApi;

$strategy->handle($user, $request); // Works
$strategy->handle($user, $request); // Throws RateLimitExceededException
```

### Rate limiters

Rate comes with a more expressive way of creating rate limiters:

```php
use Armory\Rate\Rate;

// Uses a dynamic strategy and memory repository allowing 2 events within 3 seconds
$rate = (new Rate)->dynamic()
    ->allow(2)
    ->seconds(3);

// 'request.api' is the event and '127.0.0.1' is the actor
$rate->handle('request.api')->as('127.0.0.1');
$rate->handle('request.api')->as('127.0.0.1');
$rate->handle('request.api')->as('127.0.0.1'); // Throws RateLimitExceededException
```

### Costs

If you have multiple events that need rate limiting then one approach would be to
create new rate limiters for each endpoint like so:

```php
use Armory\Rate\Contracts\EventInterface;
use Armory\Rate\Traits\RateLimitEvent;
use Rate;

$userApi = (new Rate)->allow(100)->hour(1); // Allow 100 requests to the user api an hour
$postsApi = (new Rate)->allow(50)->hour(1); // Allow 50 requests to the posts api an hour
```

This would allow the user a total of 150 requests per hour, 100 for the user api
and 50 for the posts api. Another way to handle it is using costs:

```php
use Rate;

$api = (new Rate)->allow(200)->hour(1); // User has 200 api credits per hour

$rate->handle('request.api.user', 1)->as('127.0.0.1'); // User API requests cost 1
$rate->handle('request.api.posts', 2)->as('127.0.0.1'); // Posts API requests cost 2
```

In this case the user has 200 api credits to use. They could do:

- 200 requests to the user api or
- 100 requests to the posts api or
- 100 requests so the user api and 50 to the posts api

### Penalties

Penalties can be added when excessive rate limiting occurs. An actor will be rate
limited until the penalty is up.

```php
use Rate;

$api = (new Rate)->allow(100)->minutes(1)->penalty(60); // Allow 100 requests in 1 minute but penalize for 60 seconds if a rate limit is hit.
```

Rate limits will stack meaning that if the actor requests again within the minute penalty, an
additional 60 second penalty will occur.
