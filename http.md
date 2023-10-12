// Example usage:
$guzzleAsyncClient = new GuzzleAsyncClient();
$network = new Network($guzzleAsyncClient);

$request1 = new NetworkRequest('GET', 'https://jsonplaceholder.typicode.com/posts/1');
$request2 = new NetworkRequest('GET', 'https://jsonplaceholder.typicode.com/posts/2');

$promise1 = $network->sendAsync($request1);
$promise2 = $network->sendAsync($request2);

$promise1->then(function (ResponseInterface $response) {
    echo 'Response from request 1: ' . $response->getBody()->getContents() . PHP_EOL;
});

$promise2->then(function (ResponseInterface $response) {
    echo 'Response from request 2: ' . $response->getBody()->getContents() . PHP_EOL;
});

\GuzzleHttp\Promise\all([$promise1, $promise2])->wait();


// Example usage:
$network = new Network();
$response = $network->fetch('https://jsonplaceholder.typicode.com/posts/1');
echo $response->getStatusCode(); // Status code
echo $response->getHeaders()['content-type']; // Content-Type header
echo $response->getBody(); // Response body