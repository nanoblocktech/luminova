<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace App\Controllers;
use App\Controllers\Application;
class Home2 extends Application {
    /**
    * Extending  App\Controllers\Application; in your controller
    * You will not have access for request and validation class instance
    * Your can access your custom application instance
    */
    public function page(): void
    {
        $this->render("index")->view();
    }
}
