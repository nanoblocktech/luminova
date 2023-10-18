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
 * Import autoload
*/
require_once(__DIR__ . '/../system/plugins/autoload.php');
use \App\Controllers\Application;

/**
 * Initializes your application instance
*/

$app = new Application(__DIR__);

/**
 * Grab router instance
*/
$router = $app->getRouterInstance();

/**
 * Register router global middleware security check
*/
$router->before('GET|POST', '/.*', function () use($app, $router) {

});

/**
 * Register router main page view
*/
$router->get('/', function() use ($app) {
    return $app->render("index")->view();
});

// Register more routes here

/**
 * Run your application
*/
$router->run();