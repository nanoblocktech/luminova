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
     *
     * @param string  $type  Bootstrap callback type
     * @param callable $callback Bootstrap Callback function to execute
     * @param callable|null $error Bootstrap Callback function to execute
     */
    public function __construct(string $type, callable $callback, ?callable $error = null) {
        $this->type = $type;
        $this->callback = $callback;
        $this->error = $error;
    }

    /**
     * Get bootstrap controller instance type
     * @return string $type route instance type
    */
    public function getType(): string {
        return $this->type;
    }

    /**
     * Get bootstrap controller callback function to execute
     * @return callable $callback 
    */
    public function getFunction(): callable {
        return $this->callback;
    }

    /**
     * Get bootstrap controller error callback handler
     * @return callable|null $callback 
    */
    public function getErrorHandler(): ?callable {
        return $this->error;
    }
}