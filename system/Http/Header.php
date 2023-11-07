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
use Luminova\Config\Configuration;
class Header {
    public const ERRORS = [
        404 => '404 Not Found',
        500 => '500 Internal Server Error'
    ];

    /**
     * Get all request headers.
     *
     * @return array The request headers
     */
    public static function getHeaders(): array
    {
        $headers = [];

        // If getallheaders() is available, use that
        if (function_exists('getallheaders')) {
            $headers = getallheaders();

            // getallheaders() can return false if something went wrong
            if ($headers !== false) {
                return $headers;
            }
        }

        // Method getallheaders() not available or went wrong: manually extract 'm
        foreach ($_SERVER as $name => $value) {
            if ((substr($name, 0, 5) == 'HTTP_') || ($name == 'CONTENT_TYPE') || ($name == 'CONTENT_LENGTH')) {
                $headers[str_replace(array(' ', 'Http'), array('-', 'HTTP'), ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }

        return $headers;
    }

     /**
     * Get server variables 
     * @param string $name optional name of server variable
     * @return array|string|null $_SERVER
     */
    public function getServerVariable(?string $name = null): mixed
    {
        if($name === null || $name == ''){
            return $_SERVER;
        }

        if(isset($_SERVER[$name])){
            return $_SERVER[$name];
        }

        return null;
    }

    public static function getMethod(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function getSystemHeaders(): array
    {
        return [
            'Content-Encoding' => '',
            'Content-Type' => 'text/html; charset=UTF-8',
            'Cache-Control' => 'no-store, max-age=0, no-cache',
            //'Expires' => gmdate("D, d M Y H:i:s", time() + 60 * 60 * 24) . ' GMT',
            //'Content-Length' => 0,
            'Content-Language' => 'en',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN', //'deny',
            'X-XSS-Protection' => '1; mode=block',
            'X-Firefox-Spdy' => 'h2',
            'Vary' => 'Accept-Encoding',
            'Connection' => 'close',
            'X-Powered-By' => Configuration::copyright()
        ];
    }

    /**
     * Get the request method used, taking overrides into account.
     *
     * @return string The Request method to handle
     */
    public static function getRoutingMethod(): string
    {
        $method = '';
        if(isset($_SERVER['REQUEST_METHOD'])){
            $method = $_SERVER['REQUEST_METHOD'];
            if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
                ob_start();
                $method = 'GET';
            } elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $headers = self::getHeaders();
                if (isset($headers['X-HTTP-Method-Override']) && in_array($headers['X-HTTP-Method-Override'], ['PUT', 'DELETE', 'PATCH'])) {
                    $method = $headers['X-HTTP-Method-Override'];
                }
            }
        }else if(php_sapi_name() === 'cli'){
            $method = 'CLI';
        }

        return $method;
    }
}