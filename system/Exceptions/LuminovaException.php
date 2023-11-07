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
use Luminova\Exceptions\AppException;
use \Exception;

class LuminovaException extends AppException
{
    /**
     * Constructor for LuminovaException.
     *
     * @param string     $class   The exception class
     * @param int        $code      The exception code (default: 500).
     * @param Exception $previous  The previous exception if applicable (default: null).
     */
    public function __construct(string $class = 'error', int $code = 500, Exception $previous = null)
    {
        $message = sprintf('Invalid class name provided: "%s". A valid class name is expected.', $class);
        parent::__construct($message, $code, $previous);
    }
}