<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/

/**
 * We want errors to be shown when using it from the CLI.
 * And display errors to developers 
*/
error_reporting(E_ALL);
ini_set('display_errors', '1');

/**
 * Autoload composers 
*/
require_once __DIR__ . '/../system/plugins/autoload.php';

/**
 * Check php requirements 
 * 
 * @throws STDERR
*/
if (version_compare(PHP_VERSION, 8.0, '<')) {
    $err = 'Your PHP version must be 8.0 or higher to run PHP Luminova framework. Current version: %s' . PHP_VERSION;

    if (PHP_SAPI === 'cli' || PHP_SAPI === 'phpdbg') {
        fwrite(STDERR, $err);
    }
    exit($err);
}

/**
 * Refuse to run when called from php-cgi
 * 
 * @throws STDERR
*/
if (strpos(PHP_SAPI, 'cgi') === 0) {
    $err = "The cli tool is not supported when running php-cgi. It needs php-cli to function!\n\n";

    fwrite(STDERR, $err);
    exit($err);
}

/**
 * @var string home directory path 
*/
defined('HOME_PATH') || define('HOME_PATH', realpath(rtrim(getcwd(), '\\/ ')) . DIRECTORY_SEPARATOR);

/**
 * @var string Public directory path 
*/
defined('PUBLIC_PATH') || define('PUBLIC_PATH', realpath(HOME_PATH . 'public') . DIRECTORY_SEPARATOR);

/**
 * @var string Front controller path
*/
defined('FRONT_CONTROLLER')  || define('FRONT_CONTROLLER', __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);

/**
 * Developer application Global.php file .
 * 
 * @var string $__global_dev
*/
$__global_dev = __DIR__ . '/../app/Controllers/Utils/Global.php';

/**
 * Require developer application Global.php file if exists.
*/
if(file_exists($__global_dev)){
    require_once $__global_dev;
}