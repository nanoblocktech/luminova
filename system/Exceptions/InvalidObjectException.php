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

class InvalidObjectException extends AppException
{
    /**
     * Constructor for InvalidObjectException.
     *
     * @param string     $class   The exception class
     * @param int        $code      The exception code (default: 500).
     * @param Exception $previous  The previous exception if applicable (default: null).
     */
    public function __construct(string $key = 'error', int $code = 500, Exception $previous = null)
    {
        $message = sprintf('Invalid argument type: "%s". A valid object is expected.', gettype($key));
        parent::__construct($message, $code, $previous);
    }
}