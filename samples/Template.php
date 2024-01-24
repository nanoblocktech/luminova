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

class Template { 
    /** 
     * Application template engine
     * 
     * @var string ENGINE [default, smarty] 
    */
    public const ENGINE = 'default';

    /** 
     * Application template file directory path
     * 
     * @var string $templateFolder 
    */
    public static string $templateFolder = 'resources/views';

    /** 
     * Application template optimized file directory path
     * 
     * @var string $optimizerFolder 
    */
    public static string $optimizerFolder = 'writeable/caches/optimize';

    /** 
     * Holds template assets folder
     * 
     * @var string $assetsFolder 
    */
    public static string $assetsFolder = 'assets';
    
}