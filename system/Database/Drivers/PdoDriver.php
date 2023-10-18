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
use Luminova\Exceptions\InvalidException;
use Luminova\Exceptions\InvalidObjectException;
use \PDO;
use \PDOException;
use \stdClass;

class PdoDriver implements DatabaseInterface {
    /**
    * @var PDO $connection PDO Database connection instance
    */
    protected PDO $connection; 

    /**
    * @var object $stmt pdo statement object
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
    * @var int PARAM_INT Integer Parameter
    */
    public const PARAM_INT = PDO::PARAM_INT; 
    
    /**
    * @var bool PARAM_BOOL Boolean Parameter
    */
    public const PARAM_BOOL = PDO::PARAM_BOOL;

    /**
    * @var null PARAM_NULL Null Parameter
    */
    public const PARAM_NULL = PDO::PARAM_NULL;

    /**
    * @var string PARAM_STRING String Parameter
    */
    public const PARAM_STRING = PDO::PARAM_STR;

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
     * @return PdoDriver The current class instance.
     */
    public function setDebug(bool $debug): PdoDriver {
        $this->onDebug = $debug;
        return $this;
    }

    /**
     * Initializes the database connection.
     * This method is called internally and should not be called directly.
     * @throws DatabaseException If no driver is specified
     */
    protected function initializeDatabase(): void {
        // Check if a database connection already exists or if the configuration is empty.
        if (!empty($this->connection)) {
            return;
        }

  
        // Define options for the PDO connection.
        $options = [
            PDO::ATTR_PERSISTENT => true, 
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION 
        ];

        // Based on the database version, create the corresponding database connection.
        if ($this->config->version === "mysql") {
            $this->createMySqlConnection($options);
        } elseif ($this->config->version === "pgsql") {
            $this->createPostgreSQLConnection($options);
        } elseif ($this->config->version === "sqlite" && !empty($this->config->sqlite_path)) {
            $this->createSQLiteConnection($options);
        } else {
            // Handle the case when no valid database driver is found for the specified version.
            DatabaseException::throwException("No database driver found for version '{$this->config->version}'", $this->config->production);
            
        }
    }

    /**
     * Create a MySQL database connection.
     *
     * @param array $options An array of PDO options.
     * @return void
     */
    protected function createMySqlConnection(array $options): void {
        $connectionDsn = "mysql:host={$this->config->host};port={$this->config->port};dbname={$this->config->database}";
        try {
            $this->connection = new PDO($connectionDsn, $this->config->username, $this->config->password, $options);
        } catch (PDOException $e) {
            DatabaseException::throwException($e->getMessage(), $this->config->production);
        }
    }

    /**
     * Create a PostgreSQL database connection.
     *
     * @param array $options An array of PDO options.
     * @return void
     */
    protected function createPostgreSQLConnection(array $options): void {
        $connectionDsn = "pgsql:host={$this->config->host} port={$this->config->port} dbname={$this->config->database}";
        $connectionDsn .= " user={$this->config->username} password={$this->config->password}";
        try {
            $this->connection = new PDO($connectionDsn, null, null, $options);
        } catch (PDOException $e) {
            DatabaseException::throwException($e->getMessage(), $this->config->production);
        }
    }

    /**
     * Create an SQLite database connection.
     *
     * @param array $options An array of PDO options.
     * @return void
     */
    protected function createSQLiteConnection(array $options): void {
        try {
            $this->connection = new PDO("sqlite:/" . $this->config->sqlite_path, null, null, $options);
        } catch (PDOException $e) {
            DatabaseException::throwException($e->getMessage(), $this->config->production);
        }
    }


    /**
     * Returns the error information for the last statement execution.
     *
     * @return string The error information array.
     */
    public function error(): string 
    {
        return '';
    }

    /**
     * Dumps the debug information for the last statement execution.
     *
     * @return string|null The debug information or null if debug mode is off.
     */
    public function dumpDebug(): mixed 
    {
        return $this->onDebug ? $this->stmt->debugDumpParams() : null;
    }

    /**
     * Prepares a statement for execution.
     *
     * @param string $query The SQL query.
     * @return PdoDriver The current class instance.
     */
    public function prepare(string $query): PdoDriver {
        $this->stmt = $this->connection->prepare($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     * @return PdoDriver The current class instance.
     */
    public function query(string $query): PdoDriver {
        $this->stmt = $this->connection->query($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     * @return int The affected row counts
     */
    public function exec(string $query): int {
        return $this->connection->exec($query);
    }

    /**
     * Begin transaction
     *
     * @return void 
     */
    public function beginTransaction(): void{
        $this->connection->beginTransaction();
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
        $this->connection->rollBack();
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
        if (is_null($type)) {
            switch (true) {
                case is_int($value): $type = self::PARAM_INT; break;
                case is_bool($value): $type = self::PARAM_BOOL; break;
                case is_null($value): $type = self::PARAM_NULL; break;
                default: $type = self::PARAM_STRING;
            }
        }
        return $type;
    }

    /**
     * Binds a value to a parameter.
     *
     * @param string       $param The parameter identifier.
     * @param mixed       $value The parameter value.
     * @param null|int    $type  The parameter type.
     *
     * @return PdoDriver The current class instance.
     */
    public function bind(string $param, mixed $value, mixed $type = null): PdoDriver 
    {
        $this->stmt->bindValue($param, $value, $this->getType($value, $type));
        return $this;
    }

    /**
     * Binds a variable to a parameter.
     *
     * @param string       $param The parameter identifier.
     * @param mixed       $value The parameter value.
     * @param null|int    $type  The parameter type.
     *
     * @return PdoDriver The current class instance.
     */
    public function param(string $param, mixed $value, mixed $type = null): PdoDriver 
    {
        $this->stmt->bindParam($param, $value, $this->getType($value, $type));
        return $this;
    }

    /**
     * Executes the prepared statement.
     */
    public function execute(?array $values = null): void 
    {
        try {
            $this->stmt->execute($values);
        } catch (PDOException $e) {
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
        return $this->stmt->rowCount();
    }

    /**
     * Fetches a single row as an object.
     *
     * @return mixed The result object or false if no row is found.
     */
    public function getOne(): mixed 
    {
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    /**
     * Fetches all rows as an array of objects.
     *
     * @return mixed The array of result objects.
     */
    public function getAll(): mixed 
    {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    /**
     * Fetches all rows as a 2D array of integers.
     *
     * @return array The 2D array of integers.
     */
    public function getInt(): int 
    {
        $response = $this->stmt->fetchAll(PDO::FETCH_NUM);
        if (isset($response[0][0])) {
            return (int) $response[0][0];
        }
        return $response;
    }

    /**
     * Fetches all rows as a stdClass object.
     *
     * @return stdClass The stdClass object containing the result rows.
     */
    public function getAllObject(): stdClass 
    {
        $result = new stdClass;
        $count = 0;
        while ($row = $this->stmt->fetchObject()) {
            $count++;
            $result->$count = $row;
        }
        return $result;
    }

    /**
     * Returns the ID of the last inserted row or sequence value.
     *
     * @return string The last insert ID.
     */
    public function getLastInsertId(): string 
    {
        return (string) $this->connection->lastInsertId();
    }

    /**
     * Frees up the statement cursor and sets the statement object to null.
     */
    public function free(): void 
    {
        if ($this->stmt !== null) {
            $this->stmt->closeCursor();
            $this->stmt = null;
        }
    }
     /**
     * Frees up the statement cursor and close database connection
     */
    public function close(): void 
    {
        $this->free();
        $this->connection = null;
    }
}
