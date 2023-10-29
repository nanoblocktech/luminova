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
use App\Controllers\Models\UserModel;

class UserController extends Controller
{
    /** @var \ Luminova\Http\Request $this->request */
    /** @var \Luminova\Security\InputValidator $this->validate */

    public function __construct(){
        parent::__construct();

    }
}
