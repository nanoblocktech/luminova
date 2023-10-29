<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Logger;

use Luminova\Config\Configuration;

class Logger implements LoggerInterface
{
    /**
     * Log an emergency message.
     *
     * @param string $message The emergency message to log.
     * @param array $context Additional context data (optional).
     */
    public function emergency(string $message, array $context = []): void
    {
        $this->log('emergency', $message, $context);
    }

    /**
     * Log an alert message.
     *
     * @param string $message The alert message to log.
     * @param array $context Additional context data (optional).
     */
    public function alert(string $message, array $context = []): void
    {
        $this->log('alert', $message, $context);
    }

    /**
     * Log a critical message.
     *
     * @param string $message The critical message to log.
     * @param array $context Additional context data (optional).
     */
    public function critical(string $message, array $context = []): void
    {
        $this->log('critical', $message, $context);
    }

    /**
     * Log an error message.
     *
     * @param string $message The error message to log.
     * @param array $context Additional context data (optional).
     */
    public function error(string $message, array $context = []): void
    {
        $this->log('error', $message, $context);
    }

    /**
     * Log a warning message.
     *
     * @param string $message The warning message to log.
     * @param array $context Additional context data (optional).
     */
    public function warning(string $message, array $context = []): void
    {
        $this->log('warning', $message, $context);
    }

    /**
     * Log a notice message.
     *
     * @param string $message The notice message to log.
     * @param array $context Additional context data (optional).
     */
    public function notice(string $message, array $context = []): void
    {
        $this->log('notice', $message, $context);
    }

    /**
     * Log an info message.
     *
     * @param string $message The info message to log.
     * @param array $context Additional context data (optional).
     */
    public function info(string $message, array $context = []): void
    {
        $this->log('info', $message, $context);
    }

    /**
     * Log a debug message.
     *
     * @param string $message The debug message to log.
     * @param array $context Additional context data (optional).
     */
    public function debug(string $message, array $context = []): void
    {
        $this->log('debug', $message, $context);
    }

    /**
     * Log a message at a specified log level.
     *
     * @param string $level The log level (e.g., "emergency," "error," "info").
     * @param string $message The message to log.
     * @param array $context Additional context data (optional).
     */
    public function log(string $level, string $message, array $context = []): void
    {
        $logDirectory = Configuration::getRootDirectory(__DIR__) . "writable/log/";
        $logFile = $logDirectory . "{$level}.log";

        if (!is_dir($logDirectory)) {
            mkdir($logDirectory, 0755, true);
        }
        $logEntry = $message . "\nContext: " . print_r($context, true) . PHP_EOL;
        file_put_contents($logFile, $logEntry . PHP_EOL, FILE_APPEND);
    }
}
