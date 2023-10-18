<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Database\Drivers;
use Luminova\Database\DatabaseInterface;
use Luminova\Models\DatabaseConfig;
use Luminova\Exceptions\DatabaseException;
use Luminova\Exceptions\InvalidObjectException;
use Luminova\Exceptions\InvalidException;
use \mysqli;
use \mysqli_result;
use \stdClass;
use \mysqli_sql_exception;
use \TypeError;

class MySqlDriver implements DatabaseInterface {
    /**
    * @var mysqli $connection mysqli Database connection instance
    */
    protected mysqli $connection; 

    /**
    * @var object $stmt mysqli statement object
    */
    protected $stmt;

    /**
    * @var bool $onDebug debug mode flag
    */
    protected bool $onDebug = false;

    /**
    * @var DatabaseConfig $config Database configuration
    */
    protected DatabaseConfig $config; 

    /**
    * @var array $queryParams Database queries
    */
    protected array $queryParams = [];

    /**
    * @var int $lastRowCount last row count
    */
    private int $lastRowCount = 0;


    /**
     * Constructor.
     *
     * @param DatabaseConfig $config database configuration. array
     * @throws InvalidException|InvalidObjectException If a required configuration key is missing.
     */
    public function __construct(DatabaseConfig $config) 
    {
        if (empty($config) || !is_object($config)) {
            throw new InvalidObjectException("Missing database configurations");
        }
        
        if (!$config instanceof DatabaseConfig) {
            throw new InvalidException("Invalid database configuration, required type: DatabaseConfig, but " . gettype($config) . " is given instead.");
        }
      
        $this->config = $config;
        $this->initializeDatabase();
    }

    /**
     * Sets the debug mode.
     *
     * @param bool $debug The debug mode.
     * @return MySqlDriver The current instance of the MySqlDriver class.
     */
    public function setDebug(bool $debug): MySqlDriver 
    {
        $this->onDebug = $debug;
        return $this;
    }

    /**
     * Initializes the database connection.
     * This method is called internally and should not be called directly.
     * @throws DatabaseException If no driver is specified
     */
    protected function initializeDatabase(): void 
    {
        if (!empty($this->connection)) {
            return;
        }
        try {
            $this->connection = new mysqli(
                $this->config->host,
                $this->config->username,
                $this->config->password,
                $this->config->database,
                $this->config->port
            );

            if ($this->connection->connect_error) {
                DatabaseException::throwException($this->connection->connect_error, $this->config->production);
            } else {
                $this->connection->set_charset($this->config->charset);
            }
        } catch (DatabaseException $e) {
            $e->handle($this->config->production);
        }
    }


    /**
     * Returns the error information for the last statement execution.
     *
     * @return string The error information array.
     */
    public function error(): string 
    {
        return $this->stmt->error;
    }

    /**
     * Dumps the debug information for the last statement execution.
     *
     * @return string The debug information
     */
    public function dumpDebug(): string 
    {
        return $this->onDebug ? $this->stmt->debugDumpParams() : '';
    }

    /**
     * Prepares a statement for execution.
     *
     * @param string $query The SQL query.
     *
     * @return MySqlDriver The current instance of the MySqlDriver class.
     */
    public function prepare(string $query): MySqlDriver 
    {
        $query = preg_replace('/:([a-zA-Z0-9_]+)/', '?', $query);
        $this->stmt = $this->connection->prepare($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     *
     * @return MySqlDriver The current instance of the MySqlDriver class.
     */
    public function query(string $query): MySqlDriver 
    {
        $this->stmt = $this->connection->query($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     * @return int The affected row counts
     */
    public function exec( string $query): int 
    {
        $result = $this->connection->query($query);
        if ($result === false) {
            return 0; 
        }
        return $this->connection->affected_rows;
    }

    /**
     * Begin transaction
     *
     * @return void 
     */

    public function beginTransaction(): void{
        $this->connection->begin_transaction();
    }

    /**
     * Commits transaction
     *
     * @return void 
     */
    public function commit(): void {
        $this->connection->commit();
        
    }

    /**
     * Rollback transaction if fails
     *
     * @return void
     */
    public function rollback(): void {
        $this->connection->rollback();
    }

    /**
     * Returns the appropriate parameter type based on the value and type.
     *
     * @param mixed       $value The parameter value.
     * @param null|int    $type  The parameter type.
     *
     * @return int The parameter type.
     */
    public function getType(mixed $value, ?int $type = null) : mixed 
    {
        return $type;
    }

    /**
     * Binds a value to a parameter.
     *
     * @param string       $param The parameter identifier.
     * @param mixed       $value The parameter value.
     * @param int|null    $type  The parameter type.
     *
     * @return MySqlDriver The current instance of the MySqlDriver class.
     */
    public function bind(string $param, mixed $value, ?int $type = null): MySqlDriver 
    {
        $this->queryParams[$param] = $value;
        return $this;
    }

    /**
     * Binds a variable to a parameter.
     *
     * @param string       $param The parameter identifier.
     * @param mixed       $value The parameter value.
     * @param int|null    $type  The parameter type.
     *
     * @return MySqlDriver The current instance of the MySqlDriver class.
     */
    public function param(string $param, mixed $value, ?int $type = null): MySqlDriver 
    {
        $this->stmt->bind_param($param, $value);
        return $this;
    }

    /**
     * Binds an array of values to the query parameters.
     *
     * @param array $values An associative array of parameter names and their corresponding values.
     * @return MySqlDriver The current instance of the MySqlDriver class.
     */
    public function bindValues(array $values): MySqlDriver 
    {
        foreach ($values as $key => $value) {
            $this->queryParams[$key] = $value;
        }
        return $this;
    }


    /**
     * Executes the prepared statement.
     * @throws DatabaseException 
     */

    public function execute(): void 
    {
        if(!$this->stmt){
            DatabaseException::throwException("Database operation error: Statement execution failed", $this->config->production);
            return;
        }

        try {
            if(!empty($this->queryParams)){
                $types = "";
                $values = [];
                foreach ($this->queryParams as $value) {
                    if (is_int($value)) {
                        $types .= "i";
                    } elseif (is_float($value)) {
                        $types .= "d";
                    } else {
                        $types .= "s";
                    }
                    $values[] = $value;
                }
        
                $bindParams = [$types];
                foreach ($values as &$value) {
                    $bindParams[] = &$value;
                }
                call_user_func_array([$this->stmt, 'bind_param'], $bindParams);
            }
            $this->stmt->execute();
        } catch (mysqli_sql_exception $e) {
            DatabaseException::throwException($e->getMessage(), $this->config->production);
        } catch (TypeError $e) {;
            DatabaseException::throwException($e->getMessage(), $this->config->production);
        }
    }


    /**
     * Returns the number of rows affected by the last statement execution.
     *
     * @return int The number of rows.
    */
    public function rowCount(): int 
    {
        return $this->stmt->num_rows??$this->lastRowCount;
    }

    /**
     * Fetches a single row as an object.
     * @throws DatabaseException if statement fails
     * @return array|object|null The result object or false if no row is found.
     */
    public function getOne(): mixed 
    {
        if(!$this->stmt){
            DatabaseException::throwException("Database operation error: Statement execution failed", $this->config->production);
            return null;
        }
        $result = $this->stmt->get_result();
        if ($result === false) {
            return null;
        }
        
        $row = $result->fetch_object();
        $this->lastRowCount = $result->num_rows;
        $result->close();
        
        return $row;
    }
    

    /**
     * Fetches all rows as an array of objects.
     *
     * @return array|object|null The array of result objects.
     */
    public function getAll(): mixed 
    {
        if ($this->stmt instanceof mysqli_result) {
            return $this->getAllFromQueryResult($this->stmt);
        } else {
            $result = $this->stmt->get_result();
            return $this->getAllFromQueryResult($result);
        }
    }


    /**
     * Fetches all rows from a query result as an array of objects.
     *
     * @param mixed $queryResult The query result object.
     * @throws DatabaseException if query result fails
     * @return array An array of objects representing the result rows.
     */
    private function getAllFromQueryResult(mixed $queryResult): array 
    {
        $response = [];

        // Check if the query result is false, indicating an error
        if ($queryResult === false) {
            DatabaseException::throwException("Database operation error: Statement execution failed. A boolean value was returned instead of a result object.", $this->config->production);
            return [];
        }

        // Fetch rows from the query result and add them to the response array
        while ($row = $queryResult->fetch_object()) {
            $response[] = $row;
        }

        // Close the query result
        $queryResult->close();

        // Update the last row count
        $this->lastRowCount = count($response);

        return $response;
    }


    /**
     * Fetches all rows as a stdClass object.
     *
     * @return stdClass The stdClass object containing the result rows.
     */

     public function getAllObject(): stdClass {
        $result = new stdClass;
        $count = 0;
        $meta = $this->stmt->result_metadata();
    
        $row = [];
        while ($field = $meta->fetch_field()) {
            $row[$field->name] = null;
        }
    
        $bindParams = [];
        foreach ($row as $key => &$value) {
            $bindParams[] = &$row[$key];
        }
    
        call_user_func_array([$this->stmt, 'bind_result'], $bindParams);
    
        while ($this->stmt->fetch()) {
            $count++;
            $result->$count = (object) $row;
        }
    
        $meta->close();
        $this->free();
        return $result;
    }  

    /**
     * Fetches all rows as a 2D array of integers.
     *
     * @return int 
     */
    public function getInt(): int 
    {
        $response = $this->stmt->fetch_all(MYSQLI_NUM);
        $this->free();
        if (isset($response[0][0])) {
            return (int) $response[0][0];
        }
        return $response;
    }  

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @return string The last insert ID.
     */
    public function getLastInsertId(): string 
    {
        return (string) $this->connection->insert_id;
    }

    /**
     * Frees up the statement cursor and sets the statement object to null.
     */
    public function free(): void 
    {
        if ($this->stmt !== null) {
            $this->stmt->free_result();
            $this->stmt = null;
        }
        $this->queryParams = null;
    }

    /**
     * Frees up the statement cursor and close database connection
    */
    public function close(): void {
        $this->free();
        $this->connection->close();
    }
}
