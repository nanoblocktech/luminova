<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Http\Client;

use GuzzleHttp\Client as GuzzleHttpClient;
use Luminova\Http\NetworkClientInterface;
use Luminova\Http\NetworkResponse;

class Guzzle implements NetworkClientInterface
{
    /**
     * @var GuzzleHttpClient
    */
    private $client;

    /**
     * Guzzle client constructor.
     * @param array $config client configuration
     * 
    */
    public function __construct(array $config = [])
    {
        $this->client = new GuzzleHttpClient($config);
    }

    /**
     * Perform an HTTP request using Guzzle.
     *
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $headers
     *
     * @return NetworkResponse
     */
    public function request(string $method, string $url, array $data = [], array $headers = []): NetworkResponse
    {
        $options = ['headers' => $headers];

        if ($method === 'POST') {
            $options['form_params'] = $data;
        }

        $response = $this->client->request($method, $url, $options);
        $body = $response->getBody();

        return new NetworkResponse(
            $response->getStatusCode(),
            $response->getHeaders(),
            $body,
            $body->getContents()
        );
    }
}