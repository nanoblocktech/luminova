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

use Luminova\Base\BaseConfig;
use Luminova\Database\Drivers\MySqlDriver;
use Luminova\Database\Drivers\PdoDriver;
use Luminova\Config\Database;

 /**
  * Class Connection
  *
  * Manages database connections based on configuration.
  *
  * @package Luminova\Database
*/
class Connection
{
    /** 
      * Database connection instance 
      * @var object 
    */
    protected $db;
 
    /** @var object|null */
    private static $instance = null;
 
     /**
      * Connection constructor.
      *
      * Initializes the database connection based on configuration.
      * @throws DatabaseException|InvalidException|InvalidObjectException If fails
      */
     public function __construct()
     {
        $this->db = self::createDatabaseInstance();
        $this->db->setDebug(!BaseConfig::isProduction());
     }
 
     /**
      * Get the singleton instance of Connection.
      *
      * @return object Database connection instance.
      *  @throws DatabaseException|InvalidException|InvalidObjectException If fails
      */

     public static function getInstance(): self 
     {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        
        return self::$instance;
        // return self::$instance->db;
    }
 
    /**
      * Create an instance of the database driver based on configuration.
      *
      * @return object Database driver instance (either MySqlDriver or PdoDriver).
      * @throws DatabaseException|InvalidException|InvalidObjectException If fails
    */
    private static function createDatabaseInstance(): object
    {
        return match (BaseConfig::get("database.driver")) {
            "MYSQLI" => new MySqlDriver(self::getDatabaseConfig()),
            "PDO" => new PdoDriver(self::getDatabaseConfig()),
            default => new PdoDriver(self::getDatabaseConfig())
        };
    }
 
    /**
      * Get the database configuration based on environment and settings.
      *
      * @return Database Database configuration object.
    */
    private static function getDatabaseConfig(): Database
    {
         $config = new Database();
         $config->port = BaseConfig::get("database.port");
         $config->host = BaseConfig::get("database.hostname");
         $config->version = BaseConfig::get("database.version");
         $config->charset = BaseConfig::get("database.charset");
         $config->sqlite_path = BaseConfig::get("database.sqlite.path");
         $config->production = BaseConfig::isProduction();
         $config->username = BaseConfig::isProduction() ? BaseConfig::get("database.username") : BaseConfig::get("database.development.username");
         $config->password = BaseConfig::isProduction() ? BaseConfig::get("database.password") : BaseConfig::get("database.development.password");
         $config->database = BaseConfig::isProduction() ? BaseConfig::get("database.name") : BaseConfig::get("database.development.name");
         return $config;
    }
}
 