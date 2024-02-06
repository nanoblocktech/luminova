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

class Bootstrap {
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
     * @var string $type
    */
    private string $type;

    /**
     * @var callable $callback
    */
    private $callback;

    /**
     * @var callable $error
    */
    private $error = null;

    /**
     * @var array $instances
    */
    private static $instances = [];

    /**
     *
     * @param string  $type  Bootstrap callback type
     * @param callable $callback Bootstrap Callback function to execute
     * @param ?callable $error Bootstrap Callback function to execute
     */
    public function __construct(string $type, callable $callback, ?callable $error = null) {
        $this->type = $type;
        $this->callback = $callback;
        $this->error = $error;
        
        if( $type !== self::WEB){
            static::$instances[] = $type;
        }
    }

    /**
     * Get bootstrap controller instance type
     * @return string $type route instance type
    */
    public function getType(): string 
    {
        return $this->type;
    }

    /**
     * Get bootstrap controller callback function to execute
     * @return callable $callback 
    */
    public function getFunction(): callable 
    {
        return $this->callback;
    }

    /**
     * Get bootstrap controller error callback handler
     * @return callable|null $callback 
    */
    public function getErrorHandler(): ?callable 
    {
        return $this->error;
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