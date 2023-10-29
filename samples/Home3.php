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
use \Luminova\BaseApplication;
class Home3 extends BaseApplication {
    /**
    * Extending  \Luminova\BaseApplication; in your controller
    * You will not have access for request and validation class instance
    * You are extending the framework base application
    */
    public function page(): void
    {
        $this->render("index")->view();
    }
}
