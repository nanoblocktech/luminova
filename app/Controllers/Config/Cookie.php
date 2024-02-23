<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace App\Controllers\Config;

class Cookie 
{
    /**
     * The path where session files are stored on the server.
     * @var string $savePath;
     */
    public string $savePath = ""; 

    /**
     * The lifetime of the session in seconds.
     * @var int $expiration;
     */
    public int $expiration = 365 * 24 * 60 * 60; 

    /**
     * The path to use for the session cookie.
     * @var string $sessionPath;
     */
    public string $cookiePath = "/"; 

    /**
     * The domain to use for the session cookie.
     * @var string $sessionDomain;
     */
    public string $cookieDomain = ".localhost";

     /**
     * Set the session cookie security level.
     * None, Lax, Strict 
     * @var string $sameSite;
     */
    public string $sameSite = "Lax";

    /**
     *
     * Cookie will only be set if a secure HTTPS connection exists.
     */
    public bool $secure = false;

    /**
     *
     * Cookie will only be accessible via HTTP(S) (no JavaScript).
     */
    public bool $httpOnly = true;

    /**
     * This flag allows setting a "raw" cookie, i.e., its name and value are
     * not URL encoded using `rawurlencode()`.
     *
     * If this is set to `true`, cookie names should be compliant of RFC 2616's
     * list of allowed characters.
     *
     * @see https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Set-Cookie#attributes
     * @see https://tools.ietf.org/html/rfc2616#section-2.2
     */
    public bool $cookieRaw = false;
}
