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
use Luminova\Config\Configuration;

class Welcome extends BaseController {

    public function page(): void
    {
        $this->app->render("index")->view();
    }

    public function info(): void
    {
        header("Content-type: application/json");
        echo json_encode([
            "error" => [
                "status" => "OK",
                "code" => 200,
                "version" => Configuration::version(),
                "framework" => Configuration::copyright(),
                //"details" => "The endpoint [" . $this->getView() . "] you are trying to access does not exist.",
                "timestamp" => date("Y-m-d H:i:s")
            ]
        ]);
    }
    
}