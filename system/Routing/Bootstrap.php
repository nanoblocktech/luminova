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
    public const WEB = 'web';
    public const API = 'api';
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
     */
    public function __construct(string $type, callable $callback, ?callable $error = null) {
        $this->type = $type;
        $this->callback = $callback;
        $this->error = $error;
    }

    /**
     * @return string $type Bootstrap Callback type
    */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @return callable $callback Bootstrap Callback function to execute
    */
    public function getFunction(): callable {
        return $this->callback;
    }

    public function getErrorHandler(): ?callable {
        return $this->error;
    }
}