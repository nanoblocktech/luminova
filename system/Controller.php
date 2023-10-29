<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova;

use App\Controllers\Application;
use Luminova\Http\Request;
use Luminova\Security\InputValidator;

class Controller extends Application {
    /**
     * @var Request $request http request object 
    */
    public Request $request;

    /**
     * @var InputValidator $validate input validation object 
    */
    public InputValidator $validate;
    
    public function __construct() {
        /**
         * Register request
         * @var Request $this->request request object
        */
        $this->request = new Request();

        /**
         * Register input validation
         * @var InputValidator $this->validate validation object
        */
        $this->validate = new InputValidator();
    }
}