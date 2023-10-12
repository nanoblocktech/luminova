<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Http;
use Luminova\Http\CurlClient;
class Network
{
    private $client;

    public function __construct($client = null)
    {
        $this->client = $client ?: new CurlClient();
    }

    public function send($method, $url, $data = [], $headers = [])
    {
        return $this->client->sendRequest($method, $url, $data, $headers);
    }

    public function fetch($url, $headers = [])
    {
        return $this->send('GET', $url, [], $headers);
    }

    public function post($url, $data = [], $headers = [])
    {
        return $this->send('POST', $url, $data, $headers);
    }
}