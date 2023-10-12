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
use \GuzzleHttp\Client;

class GuzzleClient
{
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function sendRequest($method, $url, $data = [], $headers = [])
    {
        $options = ['headers' => $headers];

        if ($method === 'POST') {
            $options['form_params'] = $data;
        }

        $response = $this->client->request($method, $url, $options);

        return $response->getBody()->getContents();
    }
}