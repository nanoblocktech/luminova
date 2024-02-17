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

use Luminova\Base\BaseApplication;

class Bootstrap 
{
    /** 
     * Default WEB controller type
     * @var string WEB
    */
    public const WEB = 'web';

    /** 
     * Default API controller type
     * @var string API
    */
    public const API = 'api';

    /** 
     * Default CLI controller type
     * @var string CLI
    */
    public const CLI = 'cli';

     /** 
     * Default CONSOLE controller type
     * @var string CONSOLE
    */
    public const CONSOLE = 'console';

    /**
     * @var string $name
    */
    private string $name = '';

    /**
     * @var callable $onError
    */
    private $onError = null;

    /**
     * @var BaseApplication $app
    */
    private ?BaseApplication $app = null;

    /**
     * @var array $instances
    */
    private static $instances = [];

    /**
     *
     * @param string  $name  Bootstrap route name
     * @param BaseApplication $app Application instance
     * @param ?callable $onError Bootstrap Callback function to execute
     */
    public function __construct(string $name, BaseApplication $app, ?callable $onError = null) {
        $this->name = $name;
        $this->onError = $onError;
        $this->app = $app;

        if( $name !== self::WEB){
            static::$instances[] = $name;
        }
    }

    /**
     * Get bootstrap route name
     * 
     * @return string $this->name route instance type
    */
    public function getName(): string 
    {
        return $this->name;
    }

    /**
     * Get application instance
     * 
     * @return BaseApplication $this->app; 
    */
    public function getApplication(): BaseApplication 
    {
        return $this->app;
    }

    /**
     * Get bootstrap controller error callback handler
     * 
     * @return ?callable $this->onError 
    */
    public function getErrorHandler(): ?callable 
    {
        return $this->onError;
    }

    /**
     * Get bootstrap registered custom instance
     * @return array static::$instances 
    */
    public static function getInstances(): array 
    {
        return static::$instances;
    }
}