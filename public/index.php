<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
$app = require_once __DIR__ . '/../bootstrap/load.php';

use Luminova\Routing\Bootstrap;
define('PUBLIC_CONTROLLER', __DIR__ . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== PUBLIC_CONTROLLER) {
    chdir(PUBLIC_CONTROLLER);
}

/*
* Define a function for the web error handler
*/
$WebErrorCallback = function () use ($app) {
    $app->render("404")->view([
        "error_view" => $app->getView()
    ]);
};

/*
* Define a function for the API error handler
*/
$ApiErrorCallback = function () use($app){
    header("HTTP/1.0 404 Not Found");
    header("Content-type: application/json");
    exit(json_encode([
        "error" => [
            "code" => 404,
            "details" => "The endpoint [" . $app->getView() . "] you are trying to access does not exist.",
            "timestamp" => date("Y-m-d H:i:s")
        ]
    ]));
};

/**
* bootstraps Load The Application Context
* We register all our application contexts `WEB, API, and CLI` 
* bootstraps the router and set the error handler based on context
*/
$app->router->bootstraps(
    new Bootstrap(Bootstrap::WEB, $app, $WebErrorCallback),
    new Bootstrap(Bootstrap::API, $app, $ApiErrorCallback),
    new Bootstrap(Bootstrap::CLI, $app)
);

/*
* Run Application Instance
*/
$app->router->run();