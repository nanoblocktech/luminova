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
* Register The Application Timezone
*/
date_default_timezone_set(Application::getVariables("app.timezone", 'UTC'));


/*
* Load global developer file
*/

$global = __DIR__ . '/../app/Controllers/Global.php';
if(file_exists($global)){
    include_once $global;
}

/*
* Create The Application
*/

//$app = new Application(__DIR__);
$app = Application::getInstance(__DIR__);


/*
* Return The Application Instance
*/

return $app;