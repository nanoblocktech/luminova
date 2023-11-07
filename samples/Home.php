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
use \Luminova\Controller;
class Home extends Controller {
    /**
    * Extending  Luminova\Controller; in your controller
    * You will have access for request and validation class instance
    */
    public function page(): void
    {
        $this->render("index")->view();
    }
}
