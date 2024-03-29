<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Functions;

class TorDetector 
{
    /**
     * @var string $torExitNodeListUrl
    */
    private static $torExitNodeListUrl = 'https://check.torproject.org/torbulkexitlist';

    /**
     * @var int $cacheExpiry
    */
    private static $cacheExpiry = 86400; 

    /**
     * Function to fetch and cache the Tor exit node list
     * 
     * @return string|false 
    */
    private static function fetchTorExitNodeList(): string|bool
    {
        $currentTime = time();
        if (file_exists(self::getPth()) && ($currentTime - filemtime(self::getPth()) < self::$cacheExpiry)) {
            return file_get_contents(self::getPth());
        }

        $result = file_get_contents(self::$torExitNodeListUrl);

        if($result !== false){
            file_put_contents(self::getPth(), $result);
        }

        return $result;
    }

    /**
     * Checks if the given IP address is a Tor exit node
     * 
     * @param string $ip
     * 
     * @return bool 
    */
    public static function isTorExitNode(string $ip): bool 
    {
        $result = self::fetchTorExitNodeList();
        
        if( $result === false){
            return false;
        }

        return strpos($result, $ip) !== false;
    }

    /**
     * Get storage file path
     * 
     * @return string 
    */
    private static function getPth(): string 
    {
        $path = dirname(__DIR__, 2) . DIRECTORY_SEPARATOR;
        $path .= 'writeable' . DIRECTORY_SEPARATOR;
        $path .= 'caches' . DIRECTORY_SEPARATOR;
        $path .= 'tor' . DIRECTORY_SEPARATOR;

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }        
    

        $file = $path . 'torbulkexitlist.txt';

        return $file;
        
    }
}