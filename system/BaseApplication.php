<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova;

use Luminova\Router\Router;
use Luminova\Config\DotEnv;
use Luminova\Template\Template;

class BaseApplication extends Template {

    /**
     * Base Application instance
     *
     * @var BaseApplication|null
     */
    private static $instance = null;

    /**
     * Router class instance
     *
     * @var Router
     */
    private $router;

    /**
     * Initialize the base application constructor
     *
     * @param string $dir The project root directory
     */
    public function __construct(string $dir = __DIR__) {
        // Register dotenv variables
        DotEnv::register($this->getRootDir() . DIRECTORY_SEPARATOR . '.env');
        // DotEnv::register(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . '.env');

        // Initialize the router instance
        $this->router = new Router();

        // Set application controller class namespace
        $this->router->addNamespace('\App\Controllers');
    

        // Initialize the template engine
        parent::__construct($dir);

        // If the document root is not changed to "public", manually enable the app to use "public" as the default
        if (!parent::isProduction()) {
            $this->setDocumentRoot("public");
        }

        // Set cache control for application cache
        $this->setCacheControl(parent::getVariables("cache.control"));

        // Set the current depth for template URL relative paths
        $this->setDept(substr_count(trim($this->getView(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR));

        // Set the project base path
        $this->setBasePath($this->getBasePath());

        // Initialize the global error handler
        $this->router->setErrorHandler(function() {
            exit($this->render("404")->view(["error_url" => parent::baseUrl() . $this->getView()]));
        });
    }

    /**
     * Get project assets relative directory 
     *
     * @return string
     */
    public function getAssets(): string {
        return (parent::isProduction() ? "/" : $this->getBasePath()) . "{$this->assetsFolder}/";
    }

    /**
     * Get the current view paths, segments uri
     *
     * @return string
     */
    public function getView(): string {
        return $this->router->getViewUri();
    }

    /**
     * Get application base path from router.
     *
     * @return string
     */
    public function getBasePath(): string {
        return $this->router->getBasePath();
    }

    /**
     * Get the base application instance as a singleton.
     *
     * @param string $dir The project root directory
     * @return BaseApplication
     */
    public static function getInstance(string $dir = __DIR__): BaseApplication {
        if (self::$instance === null) {
            self::$instance = new self($dir);
        }
        return self::$instance;
    }

    /**
     * Get the router instance.
     *
     * @return Router
     */
    public function getRouterInstance(): Router {
        return $this->router;
    }
}