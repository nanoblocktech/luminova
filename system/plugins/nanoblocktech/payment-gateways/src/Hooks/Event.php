<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/
namespace Luminova\ExtraUtils\Payment\Hooks;

class Event {
    /**
     * @var string $secretKey API secret key
    */
    private string $secretKey = '';

    /**
     * @var string $event Received event identifier
    */
    private string $event = '';

    /**
     * @var string SIGNATURE API key signature header
    */
    private const SIGNATURE = 'HTTP_X_PAYSTACK_SIGNATURE';

    /**
     * @var array $routes 
    */
    private array $routes = [];

    /**
     * @var array $blacklist List of IPs to blacklist
    */
    private array $blacklist = [];

    /**
     * PayStack event 
     * @var array $events allowed events  
    */
    private static $events = [
        'customeridentification.failed',
        'customeridentification.success',
        'charge.success',
        'charge.dispute.create',
        'charge.dispute.remind',
        'charge.dispute.resolve',
        'dedicatedaccount.assign.failed',
        'dedicatedaccount.assign.success',
        'paymentrequest.pending',
        'paymentrequest.success',
        'invoice.create',
        'invoice.payment_failed',
        'invoice.update',
        'refund.failed',
        'refund.pending',
        'refund.processed',
        'refund.processing',
        'subscription.create',
        'subscription.disable',
        'subscription.not_renew',
        'subscription.expiring_cards',
        'transfer.success',
        'transfer.failed',
        'transfer.reversed'
    ];

    /**
     * @var array $whitelist List of IPs to whitelist
    */
    private array $whitelist = [
        '52.31.139.75',
        '52.49.173.169',
        '52.214.14.220',
        '127.0.0.1' //localhost ip
    ];

    /**
     * Initialize event class constructor
     * @param string $key API secret key
    */
    public function __construct(string $key){
        $this->secretKey = $key;
    }

    /**
     * Add an IP to the blacklist.
     *
     * @param string $ip IP address to blacklist
     * 
     * @return void
    */
    public function addBlacklist(string $ip): void
    {
        $this->blacklist[] = $ip;
    }

    /**
     * Add an IP to the whitelist.
     *
     * @param string $ip IP address to whitelist
     * 
     * @return void
    */
    public function addWhitelist(string $ip): void
    {
        $this->whitelist[] = $ip;
    }

    /**
     * Add a route to the routing.
     *
     * @param string $name URL path.
     * @param callable $handler Callback function to execute when the route is matched.
     * 
     * @return void 
     */
    public function route(string $name, callable $callback): void 
    {
        $this->routes[][$name] = $callback;
    }

    /**
     * Get hook payload
     * 
     * @return object|bool  Object or return false if failed 
    */
    public function getResult(): object|bool 
    {
        if (!$this->isWhiteListed()) {
            return false;
        }

        $payload = static::watcher($this->secretKey);
        if($payload === false){
            return false;
        }
        $this->event = $payload->event;
        return $payload;
    }

    /**
     * Get event id
     * 
     * @return string  $this->event
    */
    public function getId(): string
    {
        return $this->event;
    }

    /**
     * Run request to the appropriate callbacks handler.
     * 
     * @return void 
    */
    public function run(): void 
    {
        $result = $this->getResult();
        if($result === false){
            $this->denyAccess();
        }

        $method = static::getMethod();
        if( $method === 'post'){
            $path = static::getPath();

            if (array_key_exists($path, $this->routes)) {
                http_response_code(200);
                $this->routes[$path]($result);
                return;
            }
        }

        $this->notFound();
    }

    /**
     * Register event watcher for webhook
     * 
     * @param string $key API secret key
     * 
     * @return object|bool 
    */
    private static function watcher(string $key): object|bool
    {
        $method = static::getMethod();
        $considerRequest = ($method  === 'post' && array_key_exists(self::SIGNATURE, $_SERVER));

        if( $considerRequest ){
            $input = file_get_contents('php://input');
            if($_SERVER[self::SIGNATURE] === hash_hmac('sha512', $input, $key)){
                $payload = json_decode($input);
                if($payload !== null && in_array($payload->event, static::$events)){
                    return $payload;
                }
            }
        }

        return false;
    }

    /**
     * Check if the request IP is allowed based on the whitelist and blacklist.
     * 
     * @return bool
    */
    private function isWhiteListed(): bool
    {
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';

        if (!empty($this->whitelist) && !in_array($ip, $this->whitelist)) {
            return false; 
        }

        if (in_array($ip, $this->blacklist)) {
            return false; 
        }

        return true;
    }

    /**
     * Get the current request URI path.
     * 
     * @return string
    */
    private static function getPath(): string
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return '/' . trim($uri, '/');
    }

    /**
     * Get the current request method
     * 
     * @return string
    */
    private static function getMethod(): string 
    {
        $method = isset($_SERVER['REQUEST_METHOD']) ? strtolower($_SERVER['REQUEST_METHOD']) : '';
        return $method;
    }

    /**
     * Exit access denied
     * 
     * @return void
    */
    public function denyAccess(): void
    {
        header("HTTP/1.0 304 Access Denied");
        exit("Access Denied");
    }

    /**
     * Exit 404 not found
     * 
     * @return void
    */
    public function notFound(): void
    {
        header("HTTP/1.0 404 Not Found");
        exit("404 Not Found");
    }
}
