<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Controllers;

use App\Controllers\Application;
use Luminova\Http\Request;
use Luminova\Security\InputValidator;

class Controller{
    /**
     * @var Request $request http request object 
    */
    protected Request $request;

    /**
     * @var InputValidator $validate input validation object 
    */
    protected InputValidator $validate;

    /**
     * @var Application $app Application instance
    */
    protected Application $app;

    /**
     * Initialize controller
     */
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

        /**
         * Initialize application instance
         * @var Application $this->app
        */
        $this->app = new Application(__DIR__);
    }
}