<?php 
namespace App\Controllers;
use \Luminova\BaseController;

class Application extends BaseController  {
    public function __construct(string $dir = __DIR__){
        parent::__construct($dir);
	}

}