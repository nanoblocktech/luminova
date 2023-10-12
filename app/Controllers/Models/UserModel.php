<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace App\Controllers\Models;
use Luminova\Models\Model;
class UserModel extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'uid';
    protected $allowedFields = ['name', 'age', 'email']; 
}
