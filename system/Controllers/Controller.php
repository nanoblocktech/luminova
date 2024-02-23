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

use \App\Controllers\Application;
use \Luminova\Http\Request;
use \Luminova\Security\InputValidator;
use \Luminova\Library\Importer;

abstract class Controller
{
    /**
     * HTTP request object 
     * @var Request $request 
    */
    protected ?Request $request = null;

    /**
     * Input validation object 
     * @var InputValidator $validate
    */
    protected ?InputValidator $validate = null;

    /**
     * Application instance
     * @var Application $app 
    */
    protected ?Application $app = null;

    /**
     * Importer instance
     * @var Importer $library 
    */
    protected ?Importer $library = null;


    /**
     * Initialize controller
     */
    public function __construct() 
    {
        $this->request = $this->request();
        $this->validate = $this->validate();
        $this->app = $this->app();
    }


    /**
     * Initializes the http request class
     * Allows #[\Override]
     * 
     * @return Request $request http request object 
    */
    public function request(): Request
    {
        if($this->request === null){
            $this->request = new Request();
        }

        return $this->request;
    }

    /**
     * Initializes the input validator class
     * Allows #[\Override]
     * 
     * @return InputValidator $validate input validation object 
    */
    public function validate(): InputValidator
    {
        if($this->validate === null){
            $this->validate = new InputValidator();
        }
        
        return $this->validate;
    }

    /**
     * Initializes the application class
     * Allows #[\Override]
     * 
     * @return Application $app Application instance
    */
    public function app(): Application
    {
        if($this->app === null){
            $this->app = new Application(__DIR__);
        }
        
        return $this->app;
    }

     /**
     * Initializes the application class
     * Allows #[\Override]
     * 
     * @return Importer $app Application instance
    */
    public function library(): Importer
    {
        if($this->library === null){
            $this->library = new Importer();
        }
        
        return $this->library;
    }
}