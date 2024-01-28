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

use Luminova\Base\BaseController;

class Home extends BaseController {
    /**
    * Extending  Luminova\Controller; in your controller
    * You will have access for request and validation class instance
    */
    public function __construct()
    {
        parent::__construct();
    }
    
    public function page(): void
    {
        $this->app->render("index")->view();
    }
}
