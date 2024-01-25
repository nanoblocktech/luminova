<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Exceptions;
use \Exception;
use Luminova\Config\Configuration;
use Luminova\Logger\Logger;

class AppException extends Exception
{
    /**
     * Constructor for AppException.
     *
     * @param string     $message   The exception message (default: 'Database error').
     * @param int        $code      The exception code (default: 500).
     * @param Exception $previous  The previous exception if applicable (default: null).
     */
    public function __construct(string $message = 'Database error', int $code = 500, Exception $previous = null)
    {
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        $message .= " Time: " . date('Y-m-d H:i:s');
        $message .= isset($caller['file']) ? " file: " .  Configuration::filterPath($caller['file']) : '';
        $message .= isset($caller['line']) ? " on line: " . $caller['line'] : '';
        parent::__construct($message, $code, $previous);
    }

    /**
     * Get a string representation of the exception.
     *
     * @return string A formatted error message.
     */
    public function __toString(): string
    {
        return "Error {$this->code}: {$this->message}";
    }

    /**
     * Handle the exception based on the production environment.
     * 
     * @throws $this Exception
     */
    public function handle(): void
    {
        if (Configuration::isProduction()) {
            $this->logException();
        } else {
            throw $this;
        }
    }

    /**
     * Logs an exception
     *
     * 
     * @return void
     */
    public function logException(): void
    {
        $message = "Exception: {$this->getMessage()}";

        (new Logger())->log('exception', $message);
    }

    /**
     * Create and handle a Exception.
     *
     * @param string $message he exception message.
     * @param bool|null $production Indicates whether it's a production environment (default: false).
     * @param int $code The exception code (default: 500).
     * 
     * @return void 
     * @throws $this Exception
     */
    public static function throwException(string $message, ?bool $production = null, int $code = 500): void
    {
        $throw = new self($message, $code);
        $throw->handle($production === null ? Configuration::isProduction() :  $production);
    }
    
}