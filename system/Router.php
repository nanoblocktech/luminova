<?php
namespace Luminova;
use Luminova\RequestHandler;

class Router extends RequestHandler{
    /**
     * @var array The route patterns and their handling functions
     */
    private $afterRoutes = array();

    /**
     * @var array The before middleware route patterns and their handling functions
     */
    private $beforeRoutes = array();

    /**
     * @var array [object|callable] The function to be executed when no route has been matched
     */
    protected $notFoundCallback = [];

    /**
     * @var string Current base route, used for (sub)route mounting
     */
    private $baseRoute = '';

    /**
     * @var string The Request Method that needs to be handled
     */
    private $requestedMethod = '';

    /**
     * @var string The Server Base Path for Router Execution
     */
    private $serverBasePath;

    /**
     * @var string Default Controllers Namespace
     */
    private $namespace = '';

    /**
     * Store a before middleware route and a handling function to be executed when accessed using one of the specified methods.
     *
     * @param string          $methods Allowed methods, | delimited
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function beforeMiddleware($methods, $pattern, $callback)
    {
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->beforeRoutes[$method][] = array(
                'pattern' => $pattern,
                'callback' => $callback,
            );
        }
    }

    /**
     * Store a route and a handling function to be executed when accessed using one of the specified methods.
     *
     * @param string          $methods Allowed methods, | delimited
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function capture($methods, $pattern, $callback)
    {
        $pattern = $this->baseRoute . '/' . trim($pattern, '/');
        $pattern = $this->baseRoute ? rtrim($pattern, '/') : $pattern;

        foreach (explode('|', $methods) as $method) {
            $this->afterRoutes[$method][] = array(
                'pattern' => $pattern,
                'callback' => $callback,
            );
        }
    }

    /**
     * Shorthand for a route accessed using any method.
     *
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function any($pattern, $callback)
    {
        $this->capture('GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD', $pattern, $callback);
    }

    /**
     * Shorthand for a route accessed using GET.
     *
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function get($pattern, $callback)
    {
        $this->capture('GET', $pattern, $callback);
    }

    /**
     * Shorthand for a route accessed using POST.
     *
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function post($pattern, $callback)
    {
        $this->capture('POST', $pattern, $callback);
    }

    /**
     * Shorthand for a route accessed using PATCH.
     *
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function patch($pattern, $callback)
    {
        $this->capture('PATCH', $pattern, $callback);
    }

    /**
     * Shorthand for a route accessed using DELETE.
     *
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function delete($pattern, $callback)
    {
        $this->capture('DELETE', $pattern, $callback);
    }

    /**
     * Shorthand for a route accessed using PUT.
     *
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function put($pattern, $callback)
    {
        $this->capture('PUT', $pattern, $callback);
    }

    /**
     * Shorthand for a route accessed using OPTIONS.
     *
     * @param string          $pattern A route pattern such as /about/system
     * @param object|callable $callback      The handling function to be executed
     */
    public function options($pattern, $callback)
    {
        $this->capture('OPTIONS', $pattern, $callback);
    }

    /**
     * Mounts a collection of callbacks onto a base route.
     *
     * @param string   $baseRoute The route sub pattern to bind the callbacks on
     * @param callable $callback        The callback method
     */
    public function bind($baseRoute, $callback)
    {
        // Track current base route
        $curBaseRoute = $this->baseRoute;

        // Build new base route string
        $this->baseRoute .= $baseRoute;

        // Call the callable
        call_user_func($callback);

        // Restore original base route
        $this->baseRoute = $curBaseRoute;
    }


    /**
     * Set a Default Lookup Namespace for Callable methods.
     *
     * @param string $namespace A given namespace
     */
    public function setNamespace($namespace)
    {
        if (is_string($namespace)) {
            $this->namespace = $namespace;
        }
    }

    /**
     * Get the given Namespace before.
     *
     * @return string The given Namespace if exists
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Execute the router: Loop all defined before middleware's and routes, and execute the handling function if a match was found.
     *
     * @param object|callable $callback Function to be executed after a matching route was handled (= after router middleware)
     *
     * @return bool
     */
    public function run($callback = null)
    {
        // Define which method we need to handle
        $this->requestedMethod = parent::getRequestMethod();

        // Handle all before middleware
        if (isset($this->beforeRoutes[$this->requestedMethod])) {
            $this->handle($this->beforeRoutes[$this->requestedMethod]);
        }

        // Handle all routes
        $numHandled = 0;
        if (isset($this->afterRoutes[$this->requestedMethod])) {
            $numHandled = $this->handle($this->afterRoutes[$this->requestedMethod], true);
        }

        // If no route was handled, trigger the error (if any)
        if ($numHandled === 0) {
            $this->triggerError($this->afterRoutes[$this->requestedMethod]);
        } // If a route was handled, perform the finish callback (if any)
        else {
            if ($callback && is_callable($callback)) {
                $callback();
            }
        }

        // If it originally was a HEAD request, clean up after ourselves by emptying the output buffer
        if ($_SERVER['REQUEST_METHOD'] == 'HEAD') {
            ob_end_clean();
        }

        // Return true if a route was handled, false otherwise
        return $numHandled !== 0;
    }

    /**
     * Set the error handling function.
     *
     * @param object|callable|string $match_callback The function to be executed
     * @param object|callable $callback The function to be executed
     */
    public function setErrorHandler($match_callback, $callback = null)
    {
      if (!is_null($callback)) {
        $this->notFoundCallback[$match_callback] = $callback;
      } else {
        $this->notFoundCallback['/'] = $match_callback;
      }
    }
    
    /**
     * Triggers error response
     *
     * @param string $pattern A route pattern such as /about/system
     */
    public function triggerError($match = null, $code = 404){

        // Counter to keep track of the number of routes we've handled
        $numHandled = 0;

        // handle error pattern
        if (count($this->notFoundCallback) > 0)
        {
            // loop fallback-routes
            foreach ($this->notFoundCallback as $route_pattern => $route_callable) {

              // matches result
              $matches = [];

              // check if there is a match and get matches as $matches (pointer)
              $is_match = $this->patternMatches($route_pattern, $this->getCurrentUri(), $matches, PREG_OFFSET_CAPTURE);

              // is fallback route match?
              if ($is_match) {

                // Rework matches to only contain the matches, not the orig string
                $matches = array_slice($matches, 1);

                // Extract the matched URL parameters (and only the parameters)
                $params = array_map(function ($match, $index) use ($matches) {

                  // We have a following parameter: take the substring from the current param position until the next one's position (thank you PREG_OFFSET_CAPTURE)
                  if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                    if ($matches[$index + 1][0][1] > -1) {
                      return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                    }
                  } // We have no following parameters: return the whole lot

                  return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                $this->execute($route_callable);

                ++$numHandled;
              }
            }
        }
        if (($numHandled == 0) && (isset($this->notFoundCallback['/']))) {
            $this->execute($this->notFoundCallback['/']);
        } elseif ($numHandled == 0) {
            header($_SERVER['SERVER_PROTOCOL'] . ' ' . parent::ERRORS[$code]??parent::ERRORS[404]);
        }
    }

    /**
    * Replace all curly braces matches {} into word patterns (like Laravel)
    * Checks if there is a routing match
    *
    * @param $pattern
    * @param $uri
    * @param $matches
    * @param $flags
    *
    * @return bool -> is match yes/no
    */
    private function patternMatches($pattern, $uri, &$matches, $flags)
    {
      // Replace all curly braces matches {} into word patterns (like Laravel)
      $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);

      // we may have a match!
      return boolval(preg_match_all('#^' . $pattern . '$#', $uri, $matches, PREG_OFFSET_CAPTURE));
    }

    /**
     * Handle a a set of routes: if a match is found, execute the relating handling function.
     *
     * @param array $routes       Collection of route patterns and their handling functions
     * @param bool  $quitAfterRun Does the handle function need to quit after one route was matched?
     *
     * @return int The number of routes handled
     */
    private function handle($routes, $quitAfterRun = false)
    {
        // Counter to keep track of the number of routes we've handled
        $numHandled = 0;

        // The current page URL
        $uri = $this->getCurrentUri();

        // Loop all routes
        foreach ($routes as $route) {

            // get routing matches
            $is_match = $this->patternMatches($route['pattern'], $uri, $matches, PREG_OFFSET_CAPTURE);

            // is there a valid match?
            if ($is_match) {

                // Rework matches to only contain the matches, not the orig string
                $matches = array_slice($matches, 1);

                // Extract the matched URL parameters (and only the parameters)
                $params = array_map(function ($match, $index) use ($matches) {

                    // We have a following parameter: take the substring from the current param position until the next one's position (thank you PREG_OFFSET_CAPTURE)
                    if (isset($matches[$index + 1]) && isset($matches[$index + 1][0]) && is_array($matches[$index + 1][0])) {
                        if ($matches[$index + 1][0][1] > -1) {
                            return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '/');
                        }
                    } // We have no following parameters: return the whole lot

                    return isset($match[0][0]) && $match[0][1] != -1 ? trim($match[0][0], '/') : null;
                }, $matches, array_keys($matches));

                // Call the handling function with the URL parameters if the desired input is callable
                $this->execute($route['callback'], $params);

                ++$numHandled;

                // If we need to quit, then quit
                if ($quitAfterRun) {
                    break;
                }
            }
        }

        // Return the number of routes handled
        return $numHandled;
    }

    private function execute($callback, $params = array())
    {
        if (is_callable($callback)) {
            call_user_func_array($callback, $params);
        }elseif (stripos($callback, '@') !== false) {
            list($controller, $method) = explode('@', $callback);
            if ($this->getNamespace() !== '') {
                $controller = $this->getNamespace() . '\\' . $controller;
            }

            try {
                $reflectedMethod = new \ReflectionMethod($controller, $method);
                // Make sure it's callable
                if ($reflectedMethod->isPublic() && (!$reflectedMethod->isAbstract())) {
                    if ($reflectedMethod->isStatic()) {
                        forward_static_call_array(array($controller, $method), $params);
                    } else {
                        if (\is_string($controller)) {
                            $controller = new $controller();
                        }
                        call_user_func_array(array($controller, $method), $params);
                    }
                }
            } catch (\ReflectionException $reflectionException) {
                // The controller class is not available or the class does not have the method $method
            }
        }
    }

    /**
     * Define the current relative URI.
     *
     * @return string
     */
    public function getCurrentUri()
    {
        $uri = substr(rawurldecode($_SERVER['REQUEST_URI']), strlen($this->getBasePath()));

        // Don't take query params into account on the URL
        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        // Remove trailing slash + enforce a slash at the start
        return '/' . trim($uri, '/');
    }

    /**
     * Return server base Path, and define it if isn't defined.
     *
     * @return string
     */
    public function getBasePath()
    {
        // Check if server base path is defined, if not define it.
        if ($this->serverBasePath === null) {
            $this->serverBasePath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
        }

        return $this->serverBasePath;
    }
    

    /**
     * @param string
     */
    public function setBasePath($serverBasePath)
    {
        $this->serverBasePath = $serverBasePath;
    }
}
