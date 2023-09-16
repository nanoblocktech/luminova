<?php 
namespace App\Controllers;
use Luminova\BaseController;
class HelloWorld extends BaseController{
    public function show(){
        return $this->render("hello")->view([
            "subtitle" => "Hello World"
        ]);
    }
}