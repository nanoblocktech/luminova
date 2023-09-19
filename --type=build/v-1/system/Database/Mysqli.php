<?php
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\Database;
use Luminova\Exceptions\DatabaseException;
use Luminova\Logger\LoggerInterface;

class Mysqli implements LoggerInterface {
    protected $connection; // Database connection object
    protected $stmt; // Mysqli statement object
    protected $onDebug = false; // Debug mode flag
    protected $config = []; // Database configuration
    protected $queryParams = [];
    protected $keys = ['VERSION', 'HOST', 'NAME', 'USERNAME', 'PASSWORD', 'CHARSET'];
    private $lastRowCount = 0;

    /**
     * Constructor.
     *
     * @param array|string|null $config The database configuration.
     * @throws \InvalidArgumentException If a required configuration key is missing.
     */
    public function __construct(mixed $config = null) {
        if (!empty($config)) {
            if (is_array($config)) {
                $this->config = $config;
            } else if (is_dir($config) && file_exists($config)) {
                $this->config = require($config);
            }

            foreach ($this->keys as $key) {
                if (!array_key_exists($key, $this->config)) {
                    throw new \InvalidArgumentException("Missing required configuration key: {$key}");
                }
            }
            $this->onCreate();
        }
    }

    /**
     * Sets a configuration value.
     *
     * @param string $key   The configuration key.
     * @param mixed  $value The configuration value.
     * @return Mysqli The current instance of the Mysqli class.
     */
    public function setConfig(string $key, mixed $value): Mysqli 
    {
        $this->config[$key] = $value;
        return $this;
    }

    /**
     * Sets the debug mode.
     *
     * @param bool $debug The debug mode.
     * @return Mysqli The current instance of the Mysqli class.
     */
    public function setDebug(bool $debug): Mysqli 
    {
        $this->onDebug = $debug;
        return $this;
    }

    /**
     * Initializes the database connection.
     * This method is called internally and should not be called directly.
     */
    protected function onCreate(): void 
    {
        // Check if the connection is already initialized or if the configuration is empty.
        if (!empty($this->connection) || empty($this->config)) {
            return;
        }
        
        try {
            // Create a new MySQLi database connection using configuration parameters.
            $this->connection = new \mysqli(
                $this->config["HOST"],
                $this->config["USERNAME"],
                $this->config["PASSWORD"],
                $this->config["NAME"],
                $this->config["PORT"]
            );

            // Check if the connection encountered an error.
            if ($this->connection->connect_error) {
                // Handle the connection error.
                $this->handleError($this->connection->connect_error);
            } else {
                // Set the character set for the connection based on the configuration.
                $this->connection->set_charset($this->config["CHARSET"]);
            }
        } catch (\Exception $e) {
            // Handle any exceptions that may occur during connection creation.
            $this->handleError($e->getMessage());
        }
    }

    

    /**
     * Returns the error information for the last statement execution.
     *
     * @return string The error information array.
     */
    public function error(): string 
    {
        return $this->handleError($this->stmt->error);
    }

    /**
     * Handles a database error by logging or throwing an exception.
     *
     * @param string $message The error message to handle.
     * @return string The original error message.
     * @throws DatabaseException If the application is in debug mode and an exception should be thrown.
     */
    private function handleError(string $message): string 
    {
        if ($this->onDebug) {
            $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
            $callerFile = isset($caller['file']) ? basename($caller['file']) : 'Unknown File';
            $callerLine = isset($caller['line']) ? $caller['line'] : 'Unknown Line';
            $message = "{$message} File: {$callerFile}, Line: {$callerLine}";
            throw new DatabaseException($message);
        } else {
            $this->log($message);
            throw new DatabaseException("Database operation error, check server error log for more details");
        }
        return $message;
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
     * @return Mysqli The current instance of the Mysqli class.
     */
    public function prepare(string $query): Mysqli 
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
     * @return Mysqli The current instance of the Mysqli class.
     */
    public function query(string $query): Mysqli 
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
     * Binds a value to a parameter.
     *
     * @param string       $param The parameter identifier.
     * @param mixed       $value The parameter value.
     * @param int|null    $type  The parameter type.
     *
     * @return Mysqli The current instance of the Mysqli class.
     */
    public function bind(string $param, mixed $value, ?int $type = null): Mysqli 
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
     * @return Mysqli The current instance of the Mysqli class.
     */
    public function param(string $param, mixed $value, ?int $type = null): Mysqli 
    {
        $this->stmt->bind_param($param, $value);
        return $this;
    }

    /**
     * Binds an array of values to the query parameters.
     *
     * @param array $values An associative array of parameter names and their corresponding values.
     * @return Mysqli The current instance of the Mysqli class.
     */
    public function bindValues(array $values): Mysqli 
    {
        foreach ($values as $key => $value) {
            $this->queryParams[$key] = $value;
        }
        return $this;
    }


    /**
     * Executes the prepared statement.
     */

    public function execute(): void 
    {
        if(!$this->stmt){
            $this->handleError("Database operation error: Statement execution failed");
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
        } catch (\mysqli_sql_exception $e) {
            $this->handleError($e->getMessage());
        } catch (\TypeError $e) {
            $this->handleError($e->getMessage());
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
     *
     * @return array|object|null The result object or false if no row is found.
     */
    public function getOne(): mixed 
    {
        if(!$this->stmt){
            $this->handleError("Database operation error: Statement execution failed");
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
        if ($this->stmt instanceof \mysqli_result) {
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
     * @return array An array of objects representing the result rows.
     */
    private function getAllFromQueryResult(mixed $queryResult): array 
    {
        $response = [];

        // Check if the query result is false, indicating an error
        if ($queryResult === false) {
            $this->handleError("Database operation error: Statement execution failed. A boolean value was returned instead of a result object.");
            return $response;
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

     public function getAllObject(): \stdClass {
        $result = new \stdClass;
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
     * Log a message to a file.
     *
     * @param string $message The log message.
     * @param array $context Additional context data to log (optional).
     *
     * @return void
     */
    public function log(string $message, array $context = []): void 
    {
        // Get the current timestamp
        $timestamp = date('Y-m-d H:i:s');

        // Define the log directory
        $filePath = dirname(dirname(__DIR__));
        $logDir = "{$filePath}/log";

        // Create the log directory if it doesn't exist
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // Define the log file path
        $logPath = "{$logDir}/database_error.txt";

        // Get information about the caller
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        $callerFile = $caller['file'] ?? 'Unknown File';
        $callerLine = $caller['line'] ?? 'Unknown Line';

        // Create the log message
        $logMessage = "[{$timestamp}] {$message}" . PHP_EOL;
        $logMessage .= "File: {$callerFile}, Line: {$callerLine}" . PHP_EOL;

        // Append context data if provided
        if (!empty($context)) {
            $logMessage .= "Context: " . json_encode($context, JSON_PRETTY_PRINT) . PHP_EOL;
        }

        // Write the log message to the log file
        file_put_contents($logPath, $logMessage, FILE_APPEND);
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
