<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
require_once(__DIR__ . '/../system/plugins/autoload.php');
use \App\Controllers\Application;
$app = new Application(__DIR__);

$router = $app->getRouterInstance();

$router->before('GET|POST', '/.*', function () use($app, $router) {
    // Middleware security check
});

$router->get('/', function() use ($app) {
    return $app->render("index")->view(["title" => "Your optional website title"]);
});

$router->get('/hello', 'HelloWorld::show');
$router->get('/profile/(.*)', 'UserController::profile');
$router->post('/profile', 'UserController::update');


$router->bind('/user', function() use ($router, $app) {

    $router->get('/', function() use ($router, $app) {
        return $app->render("user")->view();
    });

    $router->get('/([a-zA-Z0-9]+)', function($id) use ($app) {
        return $app->render("user")->view([
            "name" => $id
        ]);
    });
});

$router->run();