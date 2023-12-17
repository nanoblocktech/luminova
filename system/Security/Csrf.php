<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Security;

class Csrf {
    /**
     * Token
     *
     * @var string $token
    */
    private static $token;

    /**
     * Token session input name
     *
     * @var string $token_name
    */
    private static $token_name = "csrf_token";

    /**
     * Token session key name
     *
     * @var string $token_key
    */
    private static $token_key = "csrf_token_token";

    /**
     * Generates a CSRF token.
     *
     * @return string The generated CSRF token.
    */
    public static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    /**
     * Generate and Stores the CSRF token in the session.
     * 
     * @return void 
     */
    public static function refreshToken(): void 
    {
        self::$token = self::generateToken();
        $_SESSION[self::$token_key] = self::$token;
    }

    /**
     * Retrieves the CSRF token from the session or generates a new one if not available.
     *
     * @return string The CSRF token.
     */
    public static function getToken(): string 
    {
        if (!self::$token) {
            self::refreshToken();
        }
        return self::$token;
    }

    /**
     * Generates an HTML input field for the CSRF token.
     * 
     * @return void 
     */
    public static function inputToken(): void 
    {
        echo '<input type="hidden" name="' . self::$token_name . '" value="' . self::getToken() . '">';
    }

    /**
     * Validates a submitted CSRF token.
     *
     * @param string $token The token submitted by the user.
     *
     * @return bool True if the submitted token is valid, false otherwise.
     */
    public static function validateToken(string $token): bool 
    {
        if (isset($_SESSION[self::$token_key]) && hash_equals($_SESSION[self::$token_key], $token)) {
            unset($_SESSION[self::$token_key]);
            return true;
        }
        return false; 
    }
}
