<?php
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\Database;
use Luminova\Exceptions\DatabaseException;
use Luminova\Logger\LoggerInterface;

class Pdo implements LoggerInterface {
    protected $conn; // Database connection object
    protected $stmt; // PDO statement object
    protected $onDebug = false; // Debug mode flag
    protected $config = array(); // Database configuration
    protected $keys = ['VERSION', 'HOST', 'NAME', 'USERNAME', 'PASSWORD', 'SQLITE_PATH'];

    public const _INT = \PDO::PARAM_INT; // Parameter type constant: Integer
    public const _BOOL = \PDO::PARAM_BOOL; // Parameter type constant: Boolean
    public const _NULL = \PDO::PARAM_NULL; // Parameter type constant: Null
    public const _STRING = \PDO::PARAM_STR; // Parameter type constant: String

    /**
     * Constructor.
     *
     * @param array|string|null $config The database configuration.
     * @throws \InvalidArgumentException If a required configuration key is missing.
     */
    public function __construct($config = null) 
    {
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
     * @return Pdo The current class instance.
     */
    public function setConfig(string $key, $value) {
        $this->config[$key] = $value;
        return $this;
    }

    /**
     * Sets the debug mode.
     *
     * @param bool $debug The debug mode.
     * @return Pdo The current class instance.
     */
    public function setDebug($debug) {
        $this->onDebug = $debug;
        return $this;
    }

    /**
     * Initializes the database connection.
     * This method is called internally and should not be called directly.
     */
    protected function onCreate(): void {
        // Check if a database connection already exists or if the configuration is empty.
        if (!empty($this->conn) || empty($this->config)) {
            return;
        }

        // Determine the database version from the configuration.
        $version = ($this->config["VERSION"] ?? "unknown");

        // Define options for the PDO connection.
        $options = [
            \PDO::ATTR_PERSISTENT => true,             // Use a persistent connection.
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION  // Enable exception mode for error handling.
        ];

        // Based on the database version, create the corresponding database connection.
        if ($version === "mysql") {
            $this->createMySqlConnection($options);
        } elseif ($version === "pgsql") {
            $this->createPostgreSQLConnection($options);
        } elseif ($version === "sqlite" && !empty($this->config["SQLITE_PATH"])) {
            $this->createSQLiteConnection($options);
        } else {
            // Handle the case when no valid database driver is found for the specified version.
            $this->handleError("No database driver found for version '$version'");
        }
    }

    /**
     * Create a MySQL database connection.
     *
     * @param array $options An array of PDO options.
     * @return void
     */
    protected function createMySqlConnection(array $options): void {
        $connectionDsn = "mysql:host={$this->config["HOST"]};port={$this->config["PORT"]};dbname={$this->config["NAME"]}";
        try {
            $this->conn = new \PDO($connectionDsn, $this->config["USERNAME"], $this->config["PASSWORD"], $options);
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
        }
    }

    /**
     * Create a PostgreSQL database connection.
     *
     * @param array $options An array of PDO options.
     * @return void
     */
    protected function createPostgreSQLConnection(array $options): void {
        $connectionDsn = "pgsql:host={$this->config["HOST"]} port={$this->config["PORT"]} dbname={$this->config["NAME"]}";
        $connectionDsn .= " user={$this->config["USERNAME"]} password={$this->config["PASSWORD"]}";
        try {
            $this->conn = new \PDO($connectionDsn, null, null, $options);
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
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
            $this->conn = new \PDO("sqlite:/" . $this->config["SQLITE_PATH"], null, null, $options);
        } catch (\PDOException $e) {
            $this->handleError($e->getMessage());
        }
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
     * @return Pdo The current class instance.
     */
    public function prepare(string $query): Pdo {
        $this->stmt = $this->conn->prepare($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     * @return Pdo The current class instance.
     */
    public function query(string $query): Pdo {
        $this->stmt = $this->conn->query($query);
        return $this;
    }

    /**
     * Executes a query.
     *
     * @param string $query The SQL query.
     * @return int The affected row counts
     */
    public function exec(string $query): int {
        return $this->conn->exec($query);
    }

    /**
     * Returns the appropriate parameter type based on the value and type.
     *
     * @param mixed       $value The parameter value.
     * @param null|int    $type  The parameter type.
     *
     * @return int The parameter type.
     */
    public function getType(mixed $value, mixed $type) : mixed 
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value): $type = self::_INT; break;
                case is_bool($value): $type = self::_BOOL; break;
                case is_null($value): $type = self::_NULL; break;
                default: $type = self::_STRING;
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
     * @return Pdo The current class instance.
     */
    public function bind(string $param, mixed $value, mixed $type = null): Pdo 
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
     * @return Pdo The current class instance.
     */
    public function param(string $param, mixed $value, mixed $type = null): Pdo 
    {
        $this->stmt->bindParam($param, $value, $this->getType($value, $type));
        return $this;
    }

    /**
     * Executes the prepared statement.
     */
    public function execute(): void 
    {
        try {
            $this->stmt->execute();
        } catch (\PDOException $e) {
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
        return $this->stmt->rowCount();
    }

    /**
     * Fetches a single row as an object.
     *
     * @return mixed The result object or false if no row is found.
     */
    public function getOne(): mixed 
    {
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Fetches all rows as an array of objects.
     *
     * @return mixed The array of result objects.
     */
    public function getAll(): mixed 
    {
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Fetches all rows as a 2D array of integers.
     *
     * @return array The 2D array of integers.
     */
    public function getInt(): int 
    {
        $response = $this->stmt->fetchAll(\PDO::FETCH_NUM);
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
    public function getAllObject(): \stdClass 
    {
        $result = new \stdClass;
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
        return (string) $this->conn->lastInsertId();
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
        $this->conn = null;
    }
}
