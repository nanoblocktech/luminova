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
use Luminova\BaseController;
use App\Controllers\Models\UserModel;

class UserController extends BaseController
{
    public function __construct(){
        parent::__construct();
        $this->validate->setRules([
            'name' => 'required',
            'age' => 'required|integer|min_length(2)|max_length(3)',
            'email' => 'required|email',
        ]);

        $this->validate->setMessages([
            'name' => [
                'required' => 'The name field is required.'
            ],
            'email' => [
                'required' => 'The email field is required.',
                'email' => 'The email address is not valid.'
            ],
            'age' => [
                'required' => 'The age field is required.',
                'integer' => 'The age must be an integer.',
                'min_length' => 'The age minimum length must 2.',
                'max_length' => 'The age maximum length must 3.'
            ]
        ]);
    }
    public function update()
    {
        if ($this->request->getMethod() === 'post') {
            if ( $this->validate->validateEntries($this->request->getBody()) ) {
                $model = new UserModel();
                $data = [
                    'name' => $this->request->getPost("name"),
                    'email' => $this->request->getPost("email"),
                    'age' => $this->request->getPost("age"),
                    'created_at' => date('Y-m-d H:i:s')
                ];

                if ($model->updateRecord($this->request->getPost("id"), $data)) {
                    echo "Insertion successful";
                } else {
                    echo "Insertion failed";
                }
           }else{
                var_export($this->validate->getErrors());
           }
        }
    }

    public function profile($userId)
    {
        $model = new UserModel();
        $userInfo = $model->getRecord( $userId );
        return $this->render("profile")->view(['userInfo' => $userInfo]);
    }
}
