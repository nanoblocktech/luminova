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

class SessionConfig {
    /**
     * The name of the session cookie.
     * @var string $cookieName;
     */
    public string $cookieName = "PHPSESSID"; 

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
    public string $sessionPath = "/"; 
}
