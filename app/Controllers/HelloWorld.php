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
class HelloWorld extends Application {
    public function show(): void {
        $this->render("hello")->view([
            "subtitle" => "Hello World"
        ]);
    }
}
