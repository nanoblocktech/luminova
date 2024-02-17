<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Routing;
use Luminova\Http\Header;
use Luminova\Exceptions\ErrorException;
use Luminova\Routing\Bootstrap;
use \ReflectionMethod;
use \ReflectionException;
use \ReflectionClass;
use Luminova\Command\Terminal;
use Luminova\Base\BaseCommand;
use Luminova\Controllers\Controller;
use Luminova\Base\BaseApplication;


class Router 
{
    /**
     * Success status code
     *
     * @var int STATUS_OK
    */

    public const STATUS_OK = 0;

    /**
     * Error status code
     *
     * @var int STATUS_ERROR
    */
    public const STATUS_ERROR = 1;

    /**
     * Route patterns to handling main controllers routes
     * @var array $controllerRoutes
    */
    private array $controllerRoutes = [];

    /**
     * Route patterns and handling functions
     * @var array $afterControllerRoutes
    */
    private array $afterControllerRoutes = [];

    /**
     * before middleware route patterns and handling functions
     * @var array $middlewareRoutes
     */
    private array $middlewareRoutes = [];

    /**
     * CLI command route 
     * @var array $commandRoutes 
     */
    private array $commandRoutes = [];

    /**
      * before CLI command route middleware
     * @var array $cliMiddlewareRoutes 
     */
    private array $cliMiddlewareRoutes = [];

    /**
     * HTTP error callable functions 
     * to be executed when no matched route was found
     * @var array $errorsCallback
    */
    private array $errorsCallback = [];

    /**
     * Current base route, used for (sub)route mounting
     * @var string $baseRoute
     */
    private string $baseRoute = '';

    /**
     * HTTP Request Method 
     * @var string $requestedMethod
    */
    private string $requestedMethod = '';

    /**
     * CLI request command name
     * @var string $commandName 
    */
    private string $commandName = '';

    /**
     * Server base path for router
     * @var string $serverBasePath
    */
    private $serverBasePath;

    /**
     * Application registered controllers namespace
     * @var array $namespace
    */
    private array $namespace = [];

    /**
     * All allowed HTTP request methods
     * @var string ALL_METHODS
    */
    private const ALL_METHODS = 'GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD';

    /**
     * Before middleware route, executes the callback function before other routing will be executed
     *
     * @param string  $methods  Allowed methods, can be serrated with | pipe symbol
     * @param string  $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     * 
     * @return void
     */
    public function before(string $methods, string $pattern, callable|string $callback): void
    {
        if (empty($methods)) {
            return;
        }
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->middlewareRoutes[$method][] = [
                'pattern' => $pattern,
                'callback' => $callback,
                'middleware' => true
            ];
        }
    }

    /**
     * After middleware route, executes the callback function after before and controller routing has executed
     *
     * @param string  $methods  Allowed methods, can be serrated with | pipe symbol
     * @param string  $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     * 
     * @return void
     */
    public function after(string $methods, string $pattern, callable|string $callback): void
    {
        if (empty($methods)) {
            return;
        }

        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->afterControllerRoutes[$method][] = [
                'pattern' => $pattern,
                'callback' => $callback,
                'middleware' => false
            ];
        }
    }

      /**
     * Capture front controller request method and pattern and execute callback
     *
     * @param string  $methods Allowed methods, can be serrated with | pipe symbol
     * @param string  $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     * 
     * @return void
     */
    public function capture(string $methods, string $pattern, callable|string $callback): void
    {
        if (empty($methods)) {
            return;
        }

        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->controllerRoutes[$method][] = [
                'pattern' => $pattern,
                'callback' => $callback,
                'middleware' => false
            ];
        }
    }

    /**
     * Capture front controller command middleware security and execute callback
     *
     * @param callable|string $pattern Allowed command pattern, script name or callback function
     * @param callable|string $callback Callback function to execute
     * @param array $options Optional options
     * 
     * @return void
    */
    public function authenticate(callable|string $pattern, callable|string $callback = null, array $options = []): void
    {
        if(is_callable($pattern)){
            $callback = $pattern;
            $parsedPattern = 'before';
            $isController = false;
        }else{
            $build_pattern = $this->parsePatternValue($pattern);
        
            $parsedPattern = ($build_pattern !== false) ? $build_pattern : trim($pattern, '/');
            $isController = ($build_pattern !== false);
        }
    
        $this->cliMiddlewareRoutes["CLI"][] = [
            'callback' => $callback,
            'pattern' => $parsedPattern,
            'options' => $options,
            'controller' => $isController,
            'middleware' => true
        ];
    }

    /**
     * Capture front controller command request names and execute callback
     *
     * @param string $pattern Allowed command pattern or script name
     * @param callable|string $callback Callback function to execute
     * @param array $options Optional options
     * 
     * @return void
    */
    public function command(string $pattern, callable|string $callback, ?array $options = []): void
    {
        $build_pattern = $this->parsePatternValue($pattern);
    
        $parsedPattern = ($build_pattern !== false) ? $build_pattern : trim($pattern, '/');
        $isController = ($build_pattern !== false);
    
        $this->commandRoutes["CLI"][] = [
            'callback' => $callback,
            'pattern' => $parsedPattern,
            'options' => $options,
            'controller' => $isController,
            'middleware' => false
        ];
    }


    /**
     * Capture any method
     *
     * @param string $pattern A route pattern or template view name
     * @param callable|string $callback Handle callback for router
     * 
     * @return void
     */
    public function any(string $pattern, callable|string $callback): void
    {
        $this->capture(self::ALL_METHODS, $pattern, $callback);
    }

    /**
     * Shorthand for a route accessed using GET.
     *
     * @param string pattern A route pattern or template view name
     * @param callable|string $callback  Handle callback for router
     * 
     * @return void
     */
    public function get(string $pattern, callable|string $callback): void
    {
        $this->capture('GET', $pattern, $callback);
    }

    /**
     * Post shorthand for a route capture
     *
     * @param string  $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     * 
     * @return void
     */
    public function post(string $pattern, callable|string $callback): void
    {
        $this->capture('POST', $pattern, $callback);
    }

    /**
     * Patch shorthand for a route capture
     *
     * @param string  $pattern A route pattern or template view name
     * @param callable|string $callback Handle callback for router
     * 
     * @return void
     */
    public function patch(string $pattern, callable|string $callback): void
    {
        $this->capture('PATCH', $pattern, $callback);
    }

    /**
     * Delete shorthand for a route capture
     *
     * @param string $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     * 
     * @return void
     */
    public function delete(string $pattern, callable|string $callback): void
    {
        $this->capture('DELETE', $pattern, $callback);
    }

    /**
     * Put shorthand for a route capture
     *
     * @param string $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     * 
     * @return void
     */
    public function put(string $pattern, callable|string $callback): void
    {
        $this->capture('PUT', $pattern, $callback);
    }

    /**
     * Options shorthand for a route capture
     *
     * @param string $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     * 
     * @return void
     */
    public function options(string $pattern, callable|string $callback): void
    {
        $this->capture('OPTIONS', $pattern, $callback);
    }

    /**
     * Binds a collection of routes in a single base route.
     *
     * @param string   $baseRoute The route sub pattern to bind the callbacks on
     * @param callable $callback Callback function to execute
     * 
     * @return void
     */
    public function bind(string $baseRoute, callable $callback): void
    {
        if(is_callable($callback)){
            $curBaseRoute = $this->baseRoute;
            $this->baseRoute .= $baseRoute;
            $callback();
            $this->baseRoute = $curBaseRoute;
        }else{
           ErrorException::throwException('Invalid argument $callback: requires callable function, ' . gettype($callback) . ', is given instead.');
        }
    }

    /**
     * Bootstrap a group 
     *
     * @param Bootstrap $callbacks callable arguments
     * 
     * @return void
    */
    public function bootstraps(Bootstrap ...$callbacks): void 
    {
        if (!defined('ENVIRONMENT')) {
            define('ENVIRONMENT', getenv('app.environment.mood', 'development'));
        }
    
        $methods = explode('|', self::ALL_METHODS);
        $methods[] = 'CLI'; //Fake a request method for cli
        $method = Header::getRoutingMethod();
        if (in_array($method, $methods)) {
            $firstSegment = $this->getFirstView();
            $routeInstances = Bootstrap::getInstances();
            $currentRouteBase = $this->baseRoute;
            foreach ($callbacks as $bootstrap) {
                $name = $bootstrap->getName();
                $application = $bootstrap->getApplication();
                //$callback = $bootstrap->getFunction();
                //if ($type !== '' && is_callable($callback)) {
                if ($name !== '' &&  $application !== null) {
                    $errorHandler = $bootstrap->getErrorHandler();
                    $withError = ($errorHandler !== null && is_callable($errorHandler));
                    $this->resetRoutes();
                    if($firstSegment === $name) {
                        if ($name === Bootstrap::CLI){
                            if (!defined('CLI_ENVIRONMENT')) {
                                define('CLI_ENVIRONMENT', getenv('cli.environment.mood', 'testing'));
                            }
                            if (!defined('STDOUT')) {
                                define('STDOUT', 'php://output');
                            }
                            if(!Terminal::isCommandLine()) {
                                return;
                            }
                        }elseif($withError){
                            $this->setErrorHandler($errorHandler);
                        }
                   
                        if (in_array($name, $routeInstances)) {  
                            $this->baseRoute .= '/' . $name;
                        }
                    
                        $this->discover($name, $this, $application);
                        //$callback($this);
                        break;
                    }elseif (!in_array($firstSegment, $routeInstances) && self::isWebInstance($name, $firstSegment)) {
                        if($withError){
                            $this->setErrorHandler($errorHandler);
                        }

                        $this->discover($name, $this, $application);
                        //$callback($this);
                        break;
                    }
                }
            }
            $this->baseRoute = $currentRouteBase;
        }
    }

    /**
     * Discover route
     *
     * @param string $name bootstrap route name
     * @param Router $router Make router instance available in route
     * @param BaseApplication $app Make application instance available in route
     * 
     * @return bool
    */
    private function discover(string $name, Router $router, BaseApplication $app): void 
    {
        require dirname(__DIR__, 2) . "/routes/{$name}.php";
    }

    /**
     * Is bootstrap a web instance
     *
     * @param string $result bootstrap result
     * @param string $first First url segment
     * 
     * @return bool
    */
    private static function isWebInstance(string $result, ?string $first = null): bool 
    {
        return ($first === null || $first === '' || Bootstrap::WEB) && $result !== Bootstrap::CLI && $result !== Bootstrap::API;
    }

    /**
     * Register a class namespace to use across the application
     *
     * @param string $namespace Class namespace
     * 
     * @return void
     * @throws ErrorException
     */
    public function addNamespace(string $namespace): void
    {
        if (is_string($namespace)) {
            $this->namespace[] = $namespace;
        }else{
            ErrorException::throwException('Invalid argument $namespace: requires string, ' . gettype($namespace) . ', is given instead.');
        }
    }

    /**
     * Run the router and application: 
     * Loop all defined CLI and HTTP before middleware's, after routes and command routes
     * Execute callback function if method matches view  or command name.
     *
     * @param ?callable $callback Optional final callback function to execute after run
     * 
     * @return void
    */
    public function run(?callable $callback = null): void
    {
        $this->requestedMethod = Header::getRoutingMethod();
        $status = ($this->requestedMethod === "CLI" ? $this->runAsCli() : $this->runAsHttp());

        if ($status && $callback && is_callable($callback)) {
            $callback();
        }

        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'HEAD') {
            ob_end_clean();
        }

        exit($status == true ? 0 : 1);
    }


    /**
     * Run the CLI router and application: 
     * Loop all defined CLI routes
     *
     * @return bool
    */
    private function runAsCli(): bool
    {
        $result = true;

        if (isset($this->cliMiddlewareRoutes[$this->requestedMethod])) {
            $result = $this->handleCommand($this->cliMiddlewareRoutes[$this->requestedMethod]);
        }

        if( $result ){
            $result = false;
            if (isset($this->commandRoutes[$this->requestedMethod])) {
                $this->commandName = $this->getCommandName();
                $result = $this->handleCommand($this->commandRoutes[$this->requestedMethod]);
            }
            if (!$result) {
                echo "Unknown command: $this->commandName\n";
            }
        }

        return $result;
    }

    /**
     * Run the HTTP router and application: 
     * Loop all defined HTTP request method and view routes
     *
     * @return bool
    */
    private function runAsHttp(): bool
    {
        $result = true;

        if (isset($this->middlewareRoutes[$this->requestedMethod])) {
            $result = $this->handleWebsite($this->middlewareRoutes[$this->requestedMethod]);
        }
       
        if( $result ){
            $result = false;
            if (isset($this->controllerRoutes[$this->requestedMethod])) {
                $result = $this->handleWebsite($this->controllerRoutes[$this->requestedMethod]);
            }
            if (!$result) {
                if(isset($this->controllerRoutes[$this->requestedMethod])){
                    $this->triggerError($this->controllerRoutes[$this->requestedMethod]);
                }else{
                    $this->triggerError();
                }
            }

            if (isset($this->afterControllerRoutes[$this->requestedMethod])) {
                $this->handleWebsite($this->afterControllerRoutes[$this->requestedMethod]);
            }
        }

        return $result;
    }

    /**
     * Set the error handling function.
     *
     * @param callable $match_callback Matching callback function to be executed
     * @param callable $callback The function to be executed
     * 
     * @return void
     */
    public function setErrorHandler(mixed $match_callback, mixed $callback = null): void
    {
      if (!is_null($callback)) {
        $this->errorsCallback[$match_callback] = $callback;
      } else {
        $this->errorsCallback['/'] = $match_callback;
      }
    }
    
    /**
     * Triggers error response
     *
     * @param string $match A route pattern or template view name
     * 
     * @return void
     */
    public function triggerError(?array $match = null, int $code = 404): void
    {

        $status = false;

        if (count($this->errorsCallback) > 0)
        {
            foreach ($this->errorsCallback as $route_pattern => $route_callable) {
              $is_match = $this->patternMatches($route_pattern, $this->getView(), $matches);
              if ($is_match) {
                //$params = self::processFindMatches($matches);
                $this->execute($route_callable);
                $status = true;
              }
            }
        }

        if(!$status){
            if(isset($this->errorsCallback['/'])){
                $this->execute($this->errorsCallback['/']);
            }elseif(isset($_SERVER['SERVER_PROTOCOL'])) {
                header($_SERVER['SERVER_PROTOCOL'] . ' Error file not found');
                //header($_SERVER['SERVER_PROTOCOL'] . ' ' . (new Translator("en"))->get($code??Codes::ERROR_404));
            }
        }
    }
    
    /**
     * Handle a set of routes: if a match is found, execute the relating handling function.
     *
     * @param array $routes  Collection of route patterns and their handling functions
     *
     * @return bool $error error status [0 => true, 1 => false]
     * @throws ErrorException if method is not callable or doesn't exist
     */
    private function handleWebsite(array $routes): bool
    {
        $error = false;
        $uri = $this->getView();
        foreach ($routes as $route) {
            $is_match = $this->patternMatches($route['pattern'], $uri, $matches);
            if ($is_match) {
                $error = $this->execute($route['callback'], self::processFindMatches($matches));
                if (!$route['middleware'] || (!$error && $route['middleware'])) {
                    break;
                }
            }
        }
        return $error;
    }

    /**
    * Handle C=command router CLI callback class method with the given parameters 
    * using instance callback or reflection class
    * @param array $routes Command name array values
    * @return void $error error status [0 => true, 1 => false]
    *
    * @throws ErrorException if method is not callable or doesn't exist
    */
    private function handleCommand(array $routes): bool
    {
        $error = false;
      
        $commands = Terminal::parseCommands($_SERVER['argv'] ?? []);
        foreach ($routes as $route) {
            if ($route['controller']) {
                $queries = Terminal::getRequestCommands();
                $controllerView = trim($queries['view'], '/');
                $is_match = $this->patternMatches($route['pattern'], $queries['view'], $matches);
                if ($is_match || $controllerView === $route['pattern']) {
                    if ($is_match) {
                        $parameter = self::processFindMatches($matches);
                    } else {
                        $parameter = [$commands];
                    }
    
                    $error = $this->execute($route['callback'], $parameter);
                    if (!$route['middleware'] || (!$error && $route['middleware'])) {
                        break;
                    }
                }
            } elseif ($this->commandName === $route['pattern'] || $route['middleware']) {
                $parameter = [$commands];
                $error = $this->execute($route['callback'], $parameter);

                if (!$route['middleware'] || (!$error && $route['middleware'])) {
                    break;
                }
            }else {
               
                if(Terminal::hasCommand($this->commandName, $commands)){
                   $error = true;
                   break;
                }
            }
        }
        return $error;
    }

    /**
     * Extract matched parameters from request
     *
     * @param array $array Matches
     * 
     * @return array $params
     */
    private static function processFindMatches(array $array): array
    {
        $array = array_slice($array, 1);
        $params = array_map(function ($match, $index) use ($array) {
            if (isset($array[$index + 1]) && isset($array[$index + 1][0]) && is_array($array[$index + 1][0])) {
                if ($array[$index + 1][0][1] > -1) {
                    return trim(substr($match[0][0], 0, $array[$index + 1][0][1] - $match[0][1]), '/');
                }
            } 
            return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
        }, $array, array_keys($array));
        return  $params;
    }

    /**
    * Execute router HTTP callback class method with the given parameters using instance callback or reflection class
    *
    * @param callable|string $callback Class public callback method eg: UserController:update
    * @param array $arguments Method arguments to pass to callback method
    *
    * @return bool 
    * @throws ErrorException if method is not callable or doesn't exist
    */
    private function execute(callable|string $callback, array $arguments = []): bool
    {
        $result = true;
        //$arguments[] = $this;
        if(is_callable($callback)) {
            $result = call_user_func_array($callback, $arguments);
        } elseif (stripos($callback, '::') !== false) {
            [$controller, $method] = explode('::', $callback);
            $result = $this->reflectionClassLoader($controller, $method, $arguments);
        }
      
        return self::getStatus($result);
    }

    /**
     * Execute class using reflection method
     *
     * @param string $controller Controller class name
     * @param string $method class method to execute
     * @param array $arguments Optional arguments to pass to the method
     *
     * @return bool If method was called successfully
     * @throws ErrorException if method is not callable or doesn't exist
    */

    private function reflectionClassLoader(string $controller, string $method, array $arguments = []): bool 
    {
        $namespaces = $this->getNamespaces(); 
        $throw = true;
        $isCommand = isset($arguments[0]['command']) && Terminal::isCommandLine();
        $method = ($isCommand ? 'run' : $method); // Only call run method for CLI

        foreach ($namespaces as $namespace) {
            $className = $namespace . '\\' . $controller;

            try {
                $checkClass = new ReflectionClass($className);
              
                if (!$checkClass->isInstantiable() || 
                    !($checkClass->isSubclassOf(BaseCommand::class) || 
                        $checkClass->isSubclassOf(Controller::class) ||
                        $checkClass->isSubclassOf(BaseApplication::class))) {
                    continue;
                }
                
                $checkMethod = new ReflectionMethod($className, $method);
                if ($checkMethod->isPublic() && !$checkMethod->isAbstract()) {
                    if($checkMethod->isStatic()) {
                        ErrorException::throwException("Static method is not allowed in controller, please make '$method' none static.");
                        return false;
                    }

                    $newClass = new $className();

                    if($isCommand && $newClass !== null) {
                        [$throw, $result] = $this->invokeCommandArgs($newClass, $arguments, $className, $checkMethod);
                    }else{
                        $result = $checkMethod->invokeArgs($newClass, $arguments);
                    }
                    
                    unset($newClass);
                    
                    return self::getStatus($result);
                }
            } catch (ReflectionException $e) {
                continue;
            }
        }
    
        if ($throw) {
            ErrorException::throwException("The method '$method' is not callable in registered namespaces.");
        }
    
        return false;
    }


    /**
     * Invoke class using reflection method
     *
     * @param object $newClass Class instance
     * @param array $arguments Pass arguments to reflection method
     * @param string $className Invoking class name
     * @param ReflectionMethod $method Controller class method
     *
     * @return array<bool, bool> 
    */
    private function invokeCommandArgs(object $newClass, array $arguments, string $className, ReflectionMethod $method): array
    {
        $result = false;
        $throw = true;

        if (method_exists($newClass, 'registerCommands')) {
            $commands = $arguments[0]??[];
            $commandId = '_about_';
            if(isset($newClass->group)) {
                $commandId .= $newClass->name;
                $commands[$commandId] = [
                    'class' => $className, 
                    'group' => $newClass->group,
                    'name' => $newClass->name,
                    'options' => $newClass->options,
                    'usages' => $newClass->usages,
                    'description' => $newClass->description
                ];
            }
           
            $code = $newClass->registerCommands($commands);
            if($code === 0) {
                if (array_key_exists('help', $commands['options'])) {
                    $result = true;
                    Terminal::printHelp($commands[$commandId]);
                }else{
                    $result = $method->invokeArgs($newClass, $arguments);
                }
            } elseif($code === 1) {
                $throw = false;
            }
        }

        unset($newClass);
        
        return [$throw, $result];
    }

    /**
     * Return run status based on result
     * In cli 0 is considered as success while 1 is failure.
     * In few occasion void or null may be returned so we treat it as success
     * 
     * @param void|bool|null|int $result response from callback function
     * 
     * @return bool
    */
    private static function getStatus(mixed $result = null): bool
    {
        if ($result === false || (is_int($result) && (int) $result === 1)) {
            return false;
        }

        return true;
    }
  
    /**
     * Get list of registered namespace
     *
     * @return array List of registered namespaces
    */
    public function getNamespaces(): array
    {
        return $this->namespace;
    }
    
    /**
    * Replace all curly braces matches {} into word patterns (like Laravel)
    * Checks if there is a routing match
    *
    * @param $pattern
    * @param $uri
    * @param &$matches
    *
    * @return bool is match true or false
    */
    private function patternMatches(string $pattern, string $uri, mixed &$matches): bool
    {
      $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);
      return boolval(preg_match_all('#^' . $pattern . '$#', $uri, $matches, PREG_OFFSET_CAPTURE));
    }

    /**
     * Return server base Path, and define it if isn't defined.
     *
     * @return string
    */
    public function getBasePath(): string
    {
        if ($this->serverBasePath === null && isset($_SERVER['SCRIPT_NAME'])) {
            $this->serverBasePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }

        return $this->serverBasePath;
    }

    /**
     * Get the current view relative URI.
     * 
     * @return string
     */
    public function getView(): string
    {
        $uri = '';
        if(isset($_SERVER['REQUEST_URI'])){
            $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), mb_strlen($this->getBasePath()));
            if (strstr($uri, '?')) {
                $uri = substr($uri, 0, strpos($uri, '?'));
            }
        }else if(Terminal::isCommandLine()){
            $uri = '/cli/';
        }
        return '/' . trim($uri, '/');
    }

    /**
     * Get the current view relative URI.
     * @alias getView Aliases to getView
     * 
     * @return string
    */
    public function getViewUri(): string
    {
        return $this->getView();
    }

    /**
     * Get the current view array of segment.
     * 
     * @return array
    */
    public function getArrayViews(): array
    {
        $baseView = trim($this->getView(), '/');
        $segments = explode('/', $baseView);
        $public = array_search('public', $segments);
        if ($public !== false) {
            array_splice($segments, $public, 1);
        }

        return $segments;
    }

    /**
     * Get the current view segment by position index.
     * 
     * @param int $index position index
     * 
     * @return string view segment
    */
    public function getViewPosition(int $index = 0): string
    {
        $segments = $this->getArrayViews();
        return $segments[$index]??'';
    }

    /**
     * Get the current view first segment.
     * 
     * @return string
    */
    public function getFirstView(): string
    {
        $segments = $this->getArrayViews();
        return reset($segments);
    }
    
    /**
     * Get the current view last segment.
     * 
     * @return string
    */
    public function getLastView(): string 
    {
        $segments = $this->getArrayViews();
        return end($segments);
    }

    /**
     * Get the current view segment before last segment.
     * 
     * @return string
    */
    public function getSecondToLastView(): string 
    {
        $segments = $this->getArrayViews();
        if (count($segments) > 1) {
            $secondToLastSegment = $segments[count($segments) - 2];
            return $secondToLastSegment;
        }
        return '';
    }
    

    /**
     * Replace command script pattern values match (:value) and replace with (pattern)
     *
     * @param string $input command script pattern
     * 
     * @return string|bool $output If match return replaced string else return false
    */
    private function parsePatternValue(string $input): string|false
    {
        $input = trim($input, '/');

        if (strpos($input, '(:value)') !== false) {
            $pattern = '/\(:value\)/';
            $replacement = '([^/]+)';

            $output = preg_replace($pattern, $replacement, $input);
            return '/' . $output;
        }

        if (strstr($input, '/')) {
            return $input;
        }
        
        return false;
    }
    
    /**
     * Set application router base path
     * 
     * @param string $base
     * 
     * @return void
     */
    public function setBasePath(string $base): void
    {
        $this->serverBasePath = $base;
    }

    /**
     * Gets request command name
     *
     * @return string
    */
    private function getCommandName(): string 
    {
        $args = $_SERVER['argv'] ?? [];
        return $args[1] ?? '';
    }
    
    /**
     * Reset register routes to avoid conflicts
     * 
     * @return void
    */
    private function resetRoutes(): void
    {
        $this->controllerRoutes = [];
        $this->afterControllerRoutes = [];
        $this->middlewareRoutes = [];
        $this->commandRoutes = [];
        $this->cliMiddlewareRoutes = [];
        $this->errorsCallback = [];
    }
}
