<?php 
/**!
 * @url - https://github.com/peterujah/
 * @author - Peter (NG)
 * @company - Nanoblock Technology Nigeria Limited
 * @Url - https://github.com/nanoblocktech/luminova
 * @copyright 
 */
require_once(__DIR__ . '/../system/plugins/autoload.php');
use \Luminova\AppController;
$app = new AppController(__DIR__, true);
$router = $app->getRouterInstance();

$router->beforeMiddleware('GET|POST', '/.*', function () use($app, $router) {
    /*
    Before middleware
    Set up your website security here such as session etc....
    */
});

$router->get('/', function() use ($app) {
    return $app->render("index")->view(["title" => "Your optional website title"]);
});

$router->get('/hello', 'HelloWorld@show');

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