# Rate

A simple but extentable rate limiting package.

## Installation

Install using composer.

```
composer require armory/rate
```

Rate requires PHP7 to run.

## Documentation

### Actors

Actors are the entities that can be rate limited. They are identified by an IP address:

```php
use Armory\Rate\{
    ActorFactory
};

$actorFactory = new ActorFactory();

$actor = $actorFactory->create('127.0.0.1');
```

### Events

Events are entities that can be rate limited. Event are identified by name, can have a cost (discussed later) and is triggered by an actor.

```php
use Armory\Rate\{
    EventFactory
};

$eventFactory = new EventFactory();

$event = $eventFactory->create('request.user.api', 1, $actor); // Cost of 1
```

### Rate Limits

Rate limits are entities that contain information about the imposed limits. Rate limits can have a number of attempts, a timeframe and a penalty (discussed later).

```php
use Armory\Rate\{
    RateLimitFactory
};

$rateLimitFactory = new RateLimitFactory();

$rateLimit = $rateLimitFactory->create(100, 60, 10); // 100 requests per minute (60 seconds) with a penalty of 10 seconds for hitting the rate limit
```

### Event Repositories

Events can be persisted to a storage medium so that rate limits can be imposed across requests. Rate comes with a FakeRepository (in-memory) to get you started.

```php
use Armory\Rate\{
    EventRepositoryFactory
};

$eventRepositoryFactory = new EventRepositoryFactory();

$repository = $eventRepositoryFactory->create(); // Defaults to FakeRepository
```

### Rate Limiters

Rate limiters are entities that define a strategy for rate limiting. Rate comes with two main rate limiting strategies:

- Basic rate limiting e.g. 100 requests every hour
- Dynamic rate limiting i.e. leaky bucket

```php
use Armory\Rate\{
    RateLimiterFactory
};

$rateLimiterFactory = new RateLimiterFactory();

$rateLimiter = $rateLimiterFactory->dynamic($event, $limit, $repository);

$rateLimiter->run();
```

If a rate limited is exceeded it will throw a `Armory\Rate\Exceptions\RateLimitExceededException`.

### Costs

Costs allow for a cost/balance implementation whereby imposing a limit of 100 on the rate limiter
gives the actor a balance of 100 credits. Each event 'costs' a number of credits which subtract
from the total balance. For example:

```php
use Armory\Rate\{
    EventFactory;
};

$eventFactory = new EventFactory;

$userApi = $eventFactory->create('user.api', 1, 0); // 1 credit
$postsApi = $eventFactory->create('posts.api', 2, 0); // 2 credits
```

### Penalties

A third parameter to creating an event allows you to specify a penalty for hitting the rate limit.
If a rate limit is hit, the penalty time prevents the rate limit from passing even if the
actor would usually have credits.

```php
use Armory\Rate\{
    EventFactory
};

$eventFactory = new EventFactory;

$userApi = $eventFactory->create('user.api', 1, 20); // Hitting the rate limit puts the actor in timeout for 20 seconds
```
