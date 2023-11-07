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
        $this->render("index")->view();
    }

    public function info(): void
    {
        header("Content-type: application/json");
        echo json_encode([
            "error" => [
                "status" => "OK",
                "code" => 200,
                "version" => $this->version(),
                "framework" => $this->copyright(),
                //"details" => "The endpoint [" . $this->getView() . "] you are trying to access does not exist.",
                "timestamp" => date("Y-m-d H:i:s")
            ]
        ]);
    }
    
}