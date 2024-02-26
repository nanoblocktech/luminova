<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Email\Exceptions;

use \Luminova\Exceptions\AppException;

class MailerException extends AppException
{
    /**
     * @var array $types
    */
    private static array $types = [
        'invalid_client' => 'Invalid mail client "%s", available clients: [PHPMailer, NovaMailer].',
        'file_access' => 'File access denied for "%s"'
    ];

    /**
     * Thrown when a cookie-related error occurs.
     *
     * @param string $type The type of error.
     * @param mixed|null $name The cookie name associated with the error (if applicable).
     * @return static
     */
    public static function throwWith(string $type, mixed $name = null): self
    {
        $message = self::$types[$type] ?? 'Unknown error occurred while creating email';
        if ($name === null) {
            $finalMessage = $message;
        }else{
            $finalMessage = sprintf($message, $name);
        }

        return new static($finalMessage);
    }
}