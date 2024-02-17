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

use \Luminova\Base\BaseController;
use App\Controllers\Models\UserModel;

class UserController extends BaseController
{
    /** @var \ Luminova\Http\Request $this->request */
    /** @var \ Luminova\Application $this->app */
    /** @var \Luminova\Security\InputValidator $this->validate */


    public function page(): void
    {
        $this->app->render("index")->view();
    }
}
