<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Database;

use \stdClass;

class QueryBuilder
{
    /**
     * @var object $statement
    */
    private object $statement;

    /**
     * Initialize with executed statement
     * 
     * @param object $statement
    */
    public function __construct(object $statement){
        $this->statement = $statement;
    }

    /**
     * Fetches all rows as an array of objects.
     *
     * @return mixed The array of result objects.
     */
    public function getAll(): mixed 
    {
        return  $this->statement->getAll();
    }

     /**
     * Fetches a single row as an object.
     *
     * @return mixed The result object or false if no row is found.
     */
    public function getOne(): mixed 
    {
        return  $this->statement->getOne();
    }

    /**
     * Fetches all rows as a 2D array of integers.
     *
     * @return array The 2D array of integers.
    */
    public function getInt(): int 
    {
        return  $this->statement->getInt();
    }

    /**
     * Fetches all rows as a stdClass object.
     *
     * @return stdClass The stdClass object containing the result rows.
     */
    public function getAllObject(): stdClass 
    {
        return  $this->statement->getAllObject();
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @return string The last insert ID.
     */
    public function getLastInsertId(): string 
    {
        return  $this->statement->getLastInsertId();
    }

    /**
     * Returns the number of rows affected by the last statement execution.
     *
     * @return int The number of rows.
    */
    public function rowCount(): int 
    {
        return  $this->statement->rowCount();
    }

    /**
     * Get result 
     * 
     * @param string $type
     * 
     * @return mixed 
    */
    public function get(string $type): mixed 
    {
        return match ($type) {
            'all' => $this->statement->getAll(),
            'one' => $this->statement->getOne(),
            'total' => $this->statement->getInt(),
            'object' => $this->statement->getAllObject(),
            'lastId' => $this->statement->getLastInsertId(),
            default => $this->statement->rowCount()
        };
    }
}