<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Models;
use Luminova\Database\Query;

class Model extends Query
{
    protected $table = ''; // Table name should be specified in child models.
    protected $primaryKey = 'uid'; // Default primary key column.
    protected $allowedFields = []; // Fields that can be inserted or updated.
    protected $validationRules = [];
    protected $validationMessages = [];


    public function __construct()
    {
        parent::__construct();
    }

    public function insertRecord(array $data)
    {
        return $this->insert($this->table, $data);
    }

    public function updateRecord(string $key, array $data){
        return $this->table($this->table)->where($this->primaryKey, $key)->update($data);
    }

    public function getRecord(string $key, array $fields = ["*"]){
        return $this->table($this->table)->where($this->primaryKey, $key)->find($fields);
    }

    public function selectRecord(string $key, array $data){
        return $this->table($this->table)->where($this->primaryKey, $key)->select($fields);
    }

    public function deleteRecord(string $key, array $data){
        
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getKey()
    {
        return $this->primaryKey;
    }
}
