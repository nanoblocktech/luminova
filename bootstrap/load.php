<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
require_once __DIR__ . '/../system/plugins/autoload.php';
use \App\Controllers\Application;
$minPhpVersion = '8.0';

if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run PHP Luminova framework. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );
    exit($message);
}

/*
* Load global developer file
*/

$global = __DIR__ . '/../app/Controllers/Global.php';
if(file_exists($global)){
    include_once $global;
}

/*
* Return The Application Instance
*/

return Application::getInstance(__DIR__);