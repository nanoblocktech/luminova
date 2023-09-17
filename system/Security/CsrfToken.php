<?php 
namespace Luminova\Security;

class CsrfToken {
    private static $token;
    protected static $TOKEN_KEY = "csrf_token";

    public function __construct(){
    }

    public static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public static function storeToken(): void 
    {
        self::$token = self::generateToken();
        $_SESSION[self::$TOKEN_KEY] = self::$token;
    }

    public static function getToken(): string 
    {
        if (!self::$token) {
            self::storeToken();
        }
        return self::$token;
    }

    public static function inputToken(): void 
    {
        echo '<input type="hidden" name="csrf_token" value="' . self::getToken() . '">';
    }

    public static function validateToken(string $submittedToken): bool 
    {
        if (isset($_SESSION[self::$TOKEN_KEY]) && hash_equals($_SESSION[self::$TOKEN_KEY], $submittedToken)) {
            unset($_SESSION[self::$TOKEN_KEY]);
            return true;
        }
        return false; 
    }
}