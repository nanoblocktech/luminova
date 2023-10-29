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
use Luminova\Controller;
class Welcome extends Controller {

    public function page(): void
    {
        $this->render("index")->view([
            "subtitle" => "Hello World"
        ]);
    }

    public function info(): void
    {
       echo $this->version();
    }
    
}