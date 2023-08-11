<?php 

session_set_cookie_params(365 * 24 * 60 * 60, "/", ".{$_SERVER['SERVER_NAME']}", true, false);
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once(__DIR__ . '/../system/vendor/autoload.php');
use \Luminova\AppController;
$app = new AppController(__DIR__, true);

$request = $app->getRouter();

$request->beforeMiddleware('GET|POST', '/.*', function () use($app){
      
});

$request->get('/', function() use ($app) {
    return $app->render("index")->view();
});

$request->get('/blog', function() use ($request) {
    return $request->triggerError();
});

$request->get('/hello', 'HelloWorld@show');

$request->bind('/user', function() use ($request, $app) {

    $request->get('/', function() use ($request, $app) {
        return $app->render("user")->view();
    });

    $request->get('/([a-zA-Z0-9]+)', function($id) use ($app) {
        return $app->render("user")->view([
            "name" => $id
        ]);
    });
});

$request->run();
