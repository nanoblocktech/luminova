<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
error_reporting(E_ALL);
ini_set('display_errors', '1');

/*
| Get The Application Instance
*/

$app = require_once __DIR__ . '/../bootstrap/load.php';


/*
| Get Router Instance From Application
| $router = $app->getRouterInstance();
*/

/*
| Define a function for the web error handler
*/
$webErrorHandler = function () use ($app) {
    $app->render("404")->view([
        "error_url" => $app::baseUrl() . $app->getView()
    ]);
    exit(1);
};

/*
| Define a function for the API error handler
*/
$apiErrorHandler = function () {
    header("Content-type: application/json");
    echo json_encode([
        "error" => [
            "code" => 404,
            "details" => "The endpoint you are trying to access does not exist.",
            "timestamp" => date("Y-m-d H:i:s")
        ]
    ]);
    exit(1);
};

/*
| Define a function for the CLI error handler
*/

$cliErrorHandler = function () {
    echo "Error command: Run -help for more information";
    exit(1);
};


/*
| Bootstrap Load The Application Context
| We register all our application context `WEB, API, and CLI` 
| Bootstrap the router and set the error handler based on context
*/
$app->router->bootstrap(
    function ($router) use ($app, $webErrorHandler) {
        $router->setErrorHandler($webErrorHandler);
        require __DIR__ . '/../routes/web.php';
    },
    function ($router) use ($app, $apiErrorHandler) {
        $router->setErrorHandler($apiErrorHandler);
        require __DIR__ . '/../routes/api.php';
    },
    function ($router) use ($app, $cliErrorHandler) {
        $router->setErrorHandler($cliErrorHandler);
        require __DIR__ . '/../routes/cli.php';
    }
);

/*
| Run The Application
*/

$app->router->run();