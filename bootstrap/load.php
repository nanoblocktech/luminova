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
        'Your PHP version must be %s or higher to run Luminova. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );
    exit($message);
}

/*
| Create The Application
*/

$app = new Application(dirname(__DIR__));

/*
| Register The Application Timezone
*/
date_default_timezone_set(Application::getVariables("app.timezone", 'UTC'));


/*
| Return The Application Instance
*/

return $app;