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
    private static $token;
    protected static $TOKEN_KEY = "csrf_token";

    /**
     * Constructor for the Csrf class.
     */
    public function __construct(){
    }

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
     * Stores the CSRF token in the session.
     */
    public static function storeToken(): void 
    {
        self::$token = self::generateToken();
        $_SESSION[self::$TOKEN_KEY] = self::$token;
    }

    /**
     * Retrieves the CSRF token from the session or generates a new one if not available.
     *
     * @return string The CSRF token.
     */
    public static function getToken(): string 
    {
        if (!self::$token) {
            self::storeToken();
        }
        return self::$token;
    }

    /**
     * Generates an HTML input field for the CSRF token.
     */
    public static function inputToken(): void 
    {
        echo '<input type="hidden" name="csrf_token" value="' . self::getToken() . '">';
    }

    /**
     * Validates a submitted CSRF token.
     *
     * @param string $submittedToken The token submitted by the user.
     *
     * @return bool True if the submitted token is valid, false otherwise.
     */
    public static function validateToken(string $submittedToken): bool 
    {
        if (isset($_SESSION[self::$TOKEN_KEY]) && hash_equals($_SESSION[self::$TOKEN_KEY], $submittedToken)) {
            unset($_SESSION[self::$TOKEN_KEY]);
            return true;
        }
        return false; 
    }
}
