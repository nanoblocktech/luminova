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

 use Luminova\Http\NetworkResponse;
 use Luminova\Http\NetworkClientInterface;
 use Exception;
 
 class Curl implements NetworkClientInterface
 {
    /**
     * Curl client constructor.
     * @param array $config client configuration
     * 
    */
    public function __construct(array $config = []){ }
    
    /**
      * Perform an HTTP request using cURL.
      *
      * @param string $method
      * @param string $url
      * @param array $data
      * @param array $headers
      *
      * @return NetworkResponse
      *
      * @throws Exception
    */
    public function request(string $method, string $url, array $data = [], array $headers = []): NetworkResponse
    {
        // Validate the request method
        $method = strtoupper($method);
        if (!in_array($method, ['GET', 'POST'])) {
            throw new Exception('Invalid request method. Supported methods: GET, POST.');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        // Set request method
        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);

            // Encode data as JSON if provided
            if (!empty($data) && is_array($data)) {
                $data = json_encode($data);
                $headers['Content-Type'] = 'application/json';
            }

            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        // Set custom headers if provided
        if ($headers !== []) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $this->toRequestHeaders($headers));
        }

        // Execute cURL request
        $response = curl_exec($ch);

        if ($response === false) {
            throw new Exception('cURL error: ' . curl_error($ch));
        }

        // Extract response information
        $info = curl_getinfo($ch);
        $statusCode = $info['http_code'] ?? 0;
        $headerSize = $info['header_size'] ?? 0;
        $responseHeaders = substr($response, 0, strpos($response, "\r\n\r\n"));
        $contents = substr($response, $headerSize);
        $responseHeaders = $this->headerToArray($responseHeaders, $statusCode);
        curl_close($ch);

        return new NetworkResponse($statusCode, $responseHeaders, $response, $contents);
    }
 
    /**
      * Convert an array of headers to cURL format.
      *
      * @param array $headers
      *
      * @return array
    */
    private function toRequestHeaders(array $headers): array
    {
        $headerLines = [];
        foreach ($headers as $key => $value) {
            $headerLines[] = "{$key}: {$value}";
        }
        return $headerLines;
    }
 
    /**
      * Convert a raw header string to an associative array.
      *
      * @param string $header
      * @param int $code
      *
      * @return array
    */
    private function headerToArray(string $header, int $code): array
    {
        $headers = ['statusCode' => $code];
        foreach (explode("\r\n", $header) as $i => $line) {
            if ($i === 0) {
                $headers['http_code'] = $line;
            } else {
                [$key, $value] = explode(': ', $line);
                $headers[$key] = $value;
            }
        }
        return $headers;
    }
 } 