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

use Luminova\Routing\Router;
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
    public $router;

    /**
     * Initialize the base application constructor
     *
     * @param string $dir The project root directory
     */
    public function __construct(string $dir = __DIR__) {
        // Register dotenv variables
        DotEnv::register(parent::getRootDirectory($dir) . DIRECTORY_SEPARATOR . '.env');
        // DotEnv::register($this->getRootDir() . DIRECTORY_SEPARATOR . '.env');
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

        // Set the current level for template URL relative paths
        $this->setLevel(substr_count(trim($this->getView(), DIRECTORY_SEPARATOR), DIRECTORY_SEPARATOR));

        // Set the project base path
        $this->setBasePath($this->getBasePath());

        // Set the project script execution time
        $this->setExecutionLimit(parent::getVariables("script.execution.limit", 90));

        // Set response compression level
        $this->setCompressionLevel(parent::getVariables("compression.level", 6));
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
        return $this->router->getView();
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
     * @return self BaseApplication
     */
    public static function getInstance(string $dir = __DIR__): static {
        if (static::$instance === null) {
            static::$instance = new static($dir);
        }
        return static::$instance;
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