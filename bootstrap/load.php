<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
*/

require_once __DIR__ . '/autoload.php';

use \App\Controllers\Application;


/**
* Set the custom error handler for non-fatal errors
*/
set_error_handler(['\Luminova\Errors\Error', 'handle']);

/**
 * Register shutdown function to catch fatal errors
*/
register_shutdown_function(['\Luminova\Errors\Error', 'shutdown']);

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