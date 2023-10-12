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

class BaseController extends Application {
    /**
     * @var Request $request http request object 
    */
    public $request;

    /**
     * @var InputValidator $validate input validation object 
    */
    public $validate;
    
    public function __construct() {
        $this->request = new Request();
        $this->validate = new InputValidator();
    }
}