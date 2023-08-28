<?php
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\DatabaseManager;
use \Luminova\Exceptions\DatabaseException;
use \Luminova\Logger\LoggerInterface;

class MysqliDriver implements LoggerInterface {
    protected $connection; // Database connection object
    protected $stmt; // Mysqli statement object
    protected $onDebug = false; // Debug mode flag
    protected $config = []; // Database configuration
    protected $queryParams = [];
    private $lastRowCount = 0;
    protected $keys = ['VERSION', 'HOST', 'NAME', 'USERNAME', 'PASSWORD', 'CHARSET'];
    /**
     * Constructor.
     *
     * @param array|string|null $config The database configuration.
     *
     * @throws \InvalidArgumentException If a required configuration key is missing.
     */
    public function __construct($config = null) {
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
     *
     * @return DBController The current DBController instance.
     */
    public function setConfig(string $key, $value) {
        $this->config[$key] = $value;
        return $this;
    }

    /**
     * Sets the debug mode.
     *
     * @param bool $debug The debug mode.
     *
     * @return DBController The current DBController instance.
     */
    public function setDebug($debug) {
        $this->onDebug = $debug;
        return $this;
    }

    /**
     * Initializes the database connection.
     * This method is called internally and should not be called directly.
     */

    protected function onCreate() {
        if (!empty($this->connection) || empty($this->config)) {
            return;
        }
        try {
            $this->connection = new \mysqli(
                $this->config["HOST"],
                $this->config["USERNAME"],
                $this->config["PASSWORD"],
                $this->config["NAME"],
                $this->config["PORT"]
            );
    
            if ($this->connection->connect_error) {
                $this->handleError($this->connection->connect_error);
            } else {
                $this->connection->set_charset($this->config["CHARSET"]);
            }
        } catch (\Exception $e) {
            $this->handleError($e->getMessage());
        }
    }
    

    /**
     * Returns the error information for the last statement execution.
     *
     * @return array|null The error information array.
     */
    public function error() {
        return $this->handleError($this->stmt->error);
    }

    private function handleError($message) {
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
     * @return string|null The debug information or null if debug mode is off.
     */
    public function dumpDebug() {
        return $this->onDebug ? $this->stmt->debugDumpParams() : null;
    }

    /**
     * Prepares a statement for execution.
     *
     * @param string $query The SQL query.
     *
     * @return DBController The current DBController instance.
     */
    public function prepare(string $query) {
        $query = preg_replace('/:([a-zA-Z0-9_]+)/', '?', $query);
        $this->stmt = $this->connection->prepare($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     *
     * @return DBController The current DBController instance.
     */
    public function query(string $query) {
        $this->stmt = $this->connection->query($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     *
     * @return int The affected row counts
     */
    public function exec($query) {
        $result = $this->connection->query($query);
        if ($result === false) {
            return 0; 
        }
        return $this->connection->affected_rows;
    }

    /**
     * Binds a value to a parameter.
     *
     * @param mixed       $param The parameter identifier.
     * @param mixed       $value The parameter value.
     * @param null|int    $type  The parameter type.
     *
     * @return DBController The current DBController instance.
     */
    public function bind($param, $value, $type = null) {
        $this->queryParams[$param] = $value;
        return $this;
    }

    /**
     * Binds a variable to a parameter.
     *
     * @param mixed       $param The parameter identifier.
     * @param mixed       $value The parameter value.
     * @param null|int    $type  The parameter type.
     *
     * @return DBController The current DBController instance.
     */
    public function param($param, $value, $type = null) {
        $this->stmt->bind_param($param, $value);
        return $this;
    }

    public function bindValues(array $values) {
        foreach ($values as $key => $value) {
            $this->queryParams[$key] = $value;
        }
        return $this;
    }

    /**
     * Executes the prepared statement.
     *
     * @return bool True on success, false on failure.
     */

    public function execute() {
        if(!$this->stmt){
            return $this->handleError("Database operation error: Statement execution failed");
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
            return $this->stmt->execute();
        } catch (\mysqli_sql_exception $e) {
            $this->handleError($e->getMessage());
        } catch (\TypeError $e) {
            $this->handleError($e->getMessage());
        }
        return false;
    }

    

    /**
     * Returns the number of rows affected by the last statement execution.
     *
     * @return int The number of rows.
     */
    public function rowCount() {
        return $this->stmt->num_rows??$this->lastRowCount;
    }

    /**
     * Fetches a single row as an object.
     *
     * @return object|bool The result object or false if no row is found.
     */
    public function getOne() {
        if(!$this->stmt){
            return $this->handleError("Database operation error: Statement execution failed");
        }
        $result = $this->stmt->get_result();
        if ($result === false) {
            return false;
        }
        
        $row = $result->fetch_object();
        $this->lastRowCount = $result->num_rows;
        $result->close();
        
        return $row;
    }
    

    /**
     * Fetches all rows as an array of objects.
     *
     * @return array The array of result objects.
     */
    public function getAll() {
        if ($this->stmt instanceof \mysqli_result) {
            return $this->getAllFromQueryResult($this->stmt);
        } else {
            $result = $this->stmt->get_result();
            return $this->getAllFromQueryResult($result);
        }
    }
    
    private function getAllFromQueryResult($queryResult) {
        $response = [];
        if ($queryResult === false) {
            return $this->handleError("Database operation error: Statement execution failed. A boolean value was returned instead of a result object.");
        }
        while ($row = $queryResult->fetch_object()) {
            $response[] = $row;
        }
    
        $queryResult->close();
        $this->lastRowCount = count($response);
        return $response;
    }

     /**
     * Fetches all rows as a stdClass object.
     *
     * @return stdClass The stdClass object containing the result rows.
     */

     public function getAllObject() {
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
     * @return array The 2D array of integers.
     */
    public function getInt() {
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
    public function getLastInsertId() {
        return $this->connection->insert_id;
    }

    public function log($message, $context = []) {
        $timestamp = date('Y-m-d H:i:s');
        $filePath = dirname(dirname(__DIR__));
        $logDir = "{$filePath}/log";
        
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }
        
        $logPath = "{$logDir}/database_error.txt";
        
        $caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1];
        $callerFile = isset($caller['file']) ? $caller['file'] : 'Unknown File';
        $callerLine = isset($caller['line']) ? $caller['line'] : 'Unknown Line';
    
        $logMessage = "[{$timestamp}] {$message}" . PHP_EOL;
        $logMessage .= "File: {$callerFile}, Line: {$callerLine}" . PHP_EOL;
    
        if (!empty($context)) {
            $logMessage .= "Context: " . json_encode($context, JSON_PRETTY_PRINT) . PHP_EOL;
        }
    
        file_put_contents($logPath, $logMessage, FILE_APPEND);
    }

    /**
     * Frees up the statement cursor and sets the statement object to null.
     */
    public function free() {
        if ($this->stmt !== null) {
            $this->stmt->free_result();
            $this->stmt = null;
        }
        $this->queryParams = null;
    }
     /**
     * Frees up the statement cursor and close database connection
     */
    public function close() {
        $this->free();
        $this->connection->close();
    }
}
