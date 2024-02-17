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

use \Luminova\Controllers\Controller;
use App\Controllers\Application;
use Luminova\Http\Request;
use Luminova\Security\InputValidator;

abstract class ViewController extends Controller
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
     * Initialize controller
     */
    public function __construct() {}

}