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

class ViewNotFoundException extends AppException
{
    /**
     * Constructor for ViewNotFoundException.
     *
     * @param string     $view   The exception view
     * @param int        $code      The exception code (default: 500).
     * @param Exception $previous  The previous exception if applicable (default: null).
     */
    public function __construct(string $view = 'home', int $code = 500, Exception $previous = null)
    {
        $message = sprintf('Invalid view name provided: "%s". View was not found.', $view);
        parent::__construct($message, $code, $previous);
    }
}