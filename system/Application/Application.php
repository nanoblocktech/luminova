<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Application;

use Luminova\Routing\Router;
use Luminova\Config\DotEnv;
use Luminova\Template\Template;
use Luminova\Config\Configuration;

class Application {
    /**
     * Use Template trait class
     * @var Template
    */
    use Template;

    /**
     * Base Application instance
     *
     * @var Application|null
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
        DotEnv::register(Configuration::getRootDirectory($dir) . DIRECTORY_SEPARATOR . '.env');

        /*
        * Register The Application Timezone
        */
        date_default_timezone_set(Configuration::getVariables("app.timezone", 'UTC'));
       
        // Initialize the router instance
        $this->router = new Router();

        // Set application controller class namespace
        $this->router->addNamespace('\App\Controllers');

        // Initialize the template engine
        //Configuration::__construct($dir);

        // If the document root is not changed to "public", manually enable the app to use "public" as the default
        if (Configuration::usePublic()) {
            $this->setDocumentRoot("public");
        }

        // Set the project base path
        $this->setBasePath($this->getBasePath());
    }

    /**
     * Get the current view paths, segments uri
     *
     * @return string
     */
    public function getView(): string 
    {
        return $this->router->getView();
    }

    /**
     * Get application base path from router.
     *
     * @return string
     */
    public function getBasePath(): string 
    {
        return $this->router->getBasePath();
    }

    /**
     * Get the base application instance as a singleton.
     *
     * @param string $dir The project root directory
     * 
     * @return self BaseApplication
     */
    public static function getInstance(string $dir = __DIR__): static 
    {
        if (static::$instance === null) {
            static::$instance = new static($dir);
        }
        return static::$instance;
    }
}