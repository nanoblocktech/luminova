### WEBHOOK EVENT

To capture a webhook event when api send request to your application hook.
First you will need to configure your webhook routing 

Initialize your event hook 
```php 
use  Luminova\ExtraUtils\Payment\Hooks\Event;
$event = new Event("SECRETE_KEY");
```

Register your routes 

```php
$event->route('/payment', function(object $result){

});

$event->route('/payment/cancelled', function(object $result){

});
```

Finally run your event handler
```php
$event->run();
```

### EVENT HOOK METHODS

Get event request payload, it returns an object or false if failed 

```php
$event->getResult(): object|bool 
```

Get event request id 

```php
$event->getId(): string
```

Exit access denied

```php
$event->denyAccess(): void
```

Exit not found 

```php
$event->notFound(): void
```

Run request to the appropriate handle event routing callbacks.

```php
$event->run(): void 
```

Add an IP to the blacklist.

```php
$event->addBlacklist(string $ip): void
```

Add an IP to the whitelist.

```php
$event->addWhitelist(string $ip): void
```

Register webhook route, pass the route name and callback function

```php
$event->route(string $name, callable $callback): void 
```

#### Optional Usages Examples

In a situation where your application is already using a routing service or you are using a framework such as `Luminova`, `CodeIgniter` or `Laravel`, you need to register your event hook withing your application routing.
In this example we will use `Luminova` routing service, but the implementation should be similar just change the method names based on the framework you are using.

In this method you don't need to call `run()` method 

First we bind our webhooks to a route 
```php
$router->bind('/hooks', function() use ($router) {
    //Then initialize our event listeners
    $event = new Event("SECRETE_KEY");
    
    // If the result returned false we should ignore the request else process as authentication was passed
    $result = $event->getResult();
    if($result === false){
        $event->denyAccess();
    }

    // Then we register our event controllers 
    $router->post('/payment', function() use($event, $result) {
        $id = $event->getId();
        if($id === 'event.id.we.want'){
            // Do something
        }
    });

    $router->post('/payment/cancelled', function() use($result) {
       var_export($result);
    });
    
});
```

Optionally you can use middleware security, you can register your `before  middleware` globally with the right match patterns or within the `bind` method depending on your specific need and coding style see example below.

```php 
$router->bind('/hooks', function() use ($router) {
    //Then initialize our event listeners
    $event = new Event("SECRETE_KEY");

    $router->before('POST', '/.*', function () use ($router, $result) {
        if($result === false){
            return $router::STATUS_ERROR;
        }
        return $router::STATUS_OK;
    });

    // Then we register our event controllers 
    $router->post('/payment', function() use($event) {
        $result = $event->getResult();
        $id = $event->getId();
        if($id === 'event.id.we.want'){
            // Do something
        }
    });

    $router->post('/payment/cancelled', function() use($event) {
        $result = $event->getResult();
        var_export($result);
    });
    
});
``` 
