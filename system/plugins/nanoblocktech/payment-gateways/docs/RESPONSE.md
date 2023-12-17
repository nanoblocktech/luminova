### RESPONSE

The api response handling method 

Get the original response object.
return the original response object or null if not available.

```php 
$result->getResponse(): mixed
```

Get the response headers.
return array of request response headers.

```php 
$result->getHeaders(): array
```

Get a specific header by key.
return mixed value of header or null if not found.

```php 
$result->getHeader(string $key): mixed;
```

Get the HTTP status code.
return int, the request response HTTP status code or 0 if not failed.
```php 
$result->getStatus(): int
```

Check if the response is successful from gateway.
```php
$result->isSuccess(): bool
```

Get a response object body returned from gateway
```php 
$result->getBody(): object
```

Get the response data portion of the gateway response.
```php 
$result->getData(): ?object
```

Get the message from gateway response body.
```php 
$result->getMessage(): string
```

Get the error object from gateway response.
```php 
$result->getErrors(): ?object
```

Get the error message from gateway response.
```php 
$result->getError(): string
```

Get the error code from the response.

```php 
$result->getErrorCode(): int
```
