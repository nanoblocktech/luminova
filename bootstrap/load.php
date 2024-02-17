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
* Require system Common.php
*/
if (!defined('APP_COMMON')) {
    include_once __DIR__ . '/../system/Functions/Common.php';
}

/*
* Require application Global.php file if exists.
*/
$global24 = __DIR__ . '/../app/Controllers/Utils/Global.php';
if(file_exists($global24)){
    include_once $global24;
}

/*
* Return The Application Instance
*/

return Application::getInstance(__DIR__);