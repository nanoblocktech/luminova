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
use Luminova\Errors\Codes;
use Luminova\Languages\Translator;
use Luminova\Routing\Bootstrap;
use \ReflectionMethod;
use \ReflectionException;

class Router extends Header {
    /**
     * @var array Route patterns and handling functions
     */
    private array $afterRoutes = [];

    /**
     * @var array before middleware route patterns and handling functions
     */
    private array $beforeRoutes = [];

    /**
     * @var array Callable functions to be executed when no matched route was found
     */
    protected array $errorsCallback = [];

    /**
     * @var string Current base route, used for (sub)route mounting
     */
    private string $baseRoute = '';

    /**
     * @var string The Request Method that needs to be handled
     */
    private string $requestedMethod = '';

    /**
     * @var string The Server Base Path for Router Execution
     */
    private $serverBasePath;

    /**
     * @var array Application registered controllers namespace
     */
    private array $namespace = [];

    private const ALL_METHODS = 'GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD';

    /**
     * Before middleware route, executes the callback function before other routing will be executed
     *
     * @param string  $methods  Allowed methods, can be serrated with | pipe symbol
     * @param string  $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     */
    public function before(string $methods, string $pattern, callable|string $callback): void
    {
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->beforeRoutes[$method][] = [
                'pattern' => $pattern,
                'callback' => $callback,
            ];
        }
    }

    /**
     * Capture front controller request method and pattern and execute callback
     *
     * @param string  $methods Allowed methods, can be serrated with | pipe symbol
     * @param string  $pattern A route pattern or template view name
     * @param callable|string $callback Callback function to execute
     */
    public function capture(string $methods, string $pattern, callable|string $callback): void
    {
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->afterRoutes[$method][] = [
                'pattern' => $pattern,
                'callback' => $callback,
            ];
        }
    }

    /**
     * Capture any method
     *
     * @param string $pattern A route pattern or template view name
     * @param callable|string $callback Handle callback for router
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
     */
    public function bind(string $baseRoute, callable $callback): void
    {
        if(is_callable($callback)){
            $curBaseRoute = $this->baseRoute;
            $this->baseRoute .= $baseRoute;
            $callback();
            $this->baseRoute = $curBaseRoute;
        }else{
            throw new ErrorException('Invalid argument $callback: requires callable function, ' . gettype($callback) . ', is given instead.');
        }
    }

    /**
     * Bootstrap a group 
     *
     * @param Bootstrap $callbacks callable arguments
    */
    public function bootstraps(Bootstrap ...$callbacks): void {
        $methods = explode('|', self::ALL_METHODS);
        $method = parent::getRoutingMethod();
        if (in_array($method, $methods)) {
            $uri = $this->getView();
            $curBaseRoute = $this->baseRoute;
            foreach ($callbacks as $bootstrap) {
                if (!empty($bootstrap->getType()) && is_callable($bootstrap->getFunction())) {
                    $result = $bootstrap->getType();
                    $errorHandler = $bootstrap->getErrorHandler();
                    $registerError = ($errorHandler !== null && is_callable($errorHandler));
                    
                    if(preg_match('#^/' . $result . '#', $uri)) {
                        if($registerError){
                            $this->setErrorHandler($errorHandler);
                        }
                        if ($result === Bootstrap::CLI){
                            header("Content-type: text/plain");
                            if(php_sapi_name() !== 'cli') {
                                return;
                            }
                        }

                        /*
                        * Make sure is not web instance
                        */
                        if ($result !== Bootstrap::WEB) {
                            $this->baseRoute .= '/' . $result;
                        }
                    
                        $bootstrap->getFunction()($this);
                        break;
                    }else{
                        if ($result === Bootstrap::WEB) {
                            if($registerError){
                                $this->setErrorHandler($errorHandler);
                            }
                            $bootstrap->getFunction()($this);
                        }
                    }
                }
            }
            $this->baseRoute = $curBaseRoute;
        }
    }

    /**
     * Register a class namespace to use across the application
     *
     * @param string $namespace Class namespace
     * @throws ErrorException
     */
    public function addNamespace(string $namespace): void
    {
        if (is_string($namespace)) {
            $this->namespace[] = $namespace;
        }else{
            throw new ErrorException('Invalid argument $namespace: requires string, ' . gettype($namespace) . ', is given instead.');
        }
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
     * Run the router and application: Loop all defined before middleware's and routes
     * Execute callback function if method and view match was found.
     *
     * @param callable $callback Final callback function to execute after run
     *
     * @return bool
     */
    public function run(?callable $callback = null): bool
    {
        $this->requestedMethod = parent::getRoutingMethod();

        if (isset($this->beforeRoutes[$this->requestedMethod])) {
            $this->handle($this->beforeRoutes[$this->requestedMethod]);
        }

        $numHandled = 0;
        if (isset($this->afterRoutes[$this->requestedMethod])) {
            $numHandled = $this->handle($this->afterRoutes[$this->requestedMethod], true);
        }

        if ($numHandled === 0) {
            if(isset($this->afterRoutes[$this->requestedMethod])){
                $this->triggerError($this->afterRoutes[$this->requestedMethod]);
            }else{
                $this->triggerError([]);
            }
        } 
        else {
            if ($callback && is_callable($callback)) {
                $callback();
            }
        }

        if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
            ob_end_clean();
        }

        return $numHandled !== 0;
    }

    /**
     * Set the error handling function.
     *
     * @param callable $match_callback Matching callback function to be executed
     * @param callable $callback The function to be executed
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
     */
    public function triggerError(?array $match = null, int $code = 404): void{

        $numHandled = 0;

        if (count($this->errorsCallback) > 0)
        {
            foreach ($this->errorsCallback as $route_pattern => $route_callable) {
              $matches = [];
              $is_match = $this->patternMatches($route_pattern, $this->getViewUri(), $matches, PREG_OFFSET_CAPTURE);
              if ($is_match) {
                $matches = array_slice($matches, 1);
                $params = array_map(function ($match, $index) use ($matches) {

                  if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                    if ($matches[$index + 1][0][1] > -1) {
                      return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                    }
                  } 

                  return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                $this->execute($route_callable);

                ++$numHandled;
              }
            }
        }
        if (($numHandled == 0) && (isset($this->errorsCallback['/']))) {
            $this->execute($this->errorsCallback['/']);
        } elseif ($numHandled == 0) {
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . (new Translator("en"))->get($code??Codes::ERROR_404));
        }
    }

    /**
     * Handle a set of routes: if a match is found, execute the relating handling function.
     *
     * @param array $routes  Collection of route patterns and their handling functions
     * @param bool  $quitAfterRun Does the handle function need to quit after one route was matched?
     *
     * @return int The number of routes handled
     */
    private function handle(array $routes, bool $quitAfterRun = false): int
    {
        $numHandled = 0;
        $uri = $this->getViewUri();
        foreach ($routes as $route) {
            $is_match = $this->patternMatches($route['pattern'], $uri, $matches, PREG_OFFSET_CAPTURE);
            if ($is_match) {
                $matches = array_slice($matches, 1);
                $params = array_map(function ($match, $index) use ($matches) {

                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        if ($matches[$index + 1][0][1] > -1) {
                            return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                        }
                    } 

                    return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                $this->execute($route['callback'], $params);

                ++$numHandled;

                if ($quitAfterRun) {
                    break;
                }
            }
        }
        return $numHandled;
    }


    /**
     * Execute the class method with the given parameters using reflection
    * @param callable|string $callback Class public callback method eg: UserController:update
    * @param array $arguments Method arguments to pass to callback method
    * @return void 
    * @throws ErrorException if method is not callable or doesn't exist
    */
    private function execute(callable|string $callback, array $arguments = []): void
    {
        if (is_callable($callback)) {
            call_user_func_array($callback, $arguments);
        } elseif (stripos($callback, '::') !== false) {
            [$controller, $method] = explode('::', $callback);
            $namespaces = $this->getNamespaces(); 

            foreach ($namespaces as $namespace) {
                $fullController = $namespace . '\\' . $controller;
                try {
                    $reflectedMethod = new ReflectionMethod($fullController, $method);
                    if ($reflectedMethod->isPublic() && (!$reflectedMethod->isAbstract())) {
                        if ($reflectedMethod->isStatic()) {
                            forward_static_call_array([$fullController, $method], $arguments);
                        } else {
                            $controllerInstance = new $fullController();
                            call_user_func_array([$controllerInstance, $method], $arguments);
                        }
                        return;
                    }
                } catch (ReflectionException $reflectionException) {
                    continue;
                }
            }
            throw new ErrorException("The method '$method' is not callable in any of the provided namespaces.");
        }
    }
    
    /**
    * Replace all curly braces matches {} into word patterns (like Laravel)
    * Checks if there is a routing match
    *
    * @param $pattern
    * @param $uri
    * @param $matches
    *
    * @return bool -> is match yes/no
    */
    private function patternMatches(string $pattern, string $uri, mixed &$matches): bool
    {
      $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);
      return boolval(preg_match_all('#^' . $pattern . '$#', $uri, $matches, PREG_OFFSET_CAPTURE));
    }

    /**
     * Get the current view relative URI.
     * @alias getView Aliases to getView
     * @return string
     */
    public function getViewUri(): string
    {
        return $this->getView();
    }

    /**
     * Get the current view relative URI.
     * @return string
     */
    public function getView(): string
    {
        $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), strlen($this->getBasePath()));
        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }
        return '/' . trim($uri, '/');
    }

    /**
     * Return server base Path, and define it if isn't defined.
     *
     * @return string
     */
    public function getBasePath(): string
    {
        if ($this->serverBasePath === null) {
            $this->serverBasePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }

        return $this->serverBasePath;
    }
    
    /**
     * Set application router base path
     * @param string
     */
    public function setBasePath(string $serverBasePath): void
    {
        $this->serverBasePath = $serverBasePath;
    }
  
}
