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

use Luminova\Config\BaseConfig;
use Luminova\Database\Drivers\MySqlDriver;
use Luminova\Database\Drivers\PdoDriver;
use Luminova\Models\DatabaseConfig;

 /**
  * Class Conn
  *
  * Manages database connections based on configuration.
  *
  * @package Luminova\Database
  */
 class Conn extends BaseConfig
 {
     /** @var mixed */
     public $db;
 
     /** @var object|null */
     private static $instance;
 
     /**
      * Conn constructor.
      *
      * Initializes the database connection based on configuration.
      * @throws DatabaseException|InvalidException|InvalidObjectException If fails
      */
     public function __construct()
     {
         $this->db = self::createDatabaseInstance();
         $this->db->setDebug(!parent::isProduction());
     }
 
     /**
      * Get the singleton instance of Conn.
      *
      * @return object Database connection instance.
      *  @throws DatabaseException|InvalidException|InvalidObjectException If fails
      */
     public static function getInstance(): object
     {
         if (!isset(self::$instance)) {
             self::$instance = new self();
         }
 
         return self::$instance->db;
     }
 
     /**
      * Create an instance of the database driver based on configuration.
      *
      * @return object Database driver instance (either MySqlDriver or PdoDriver).
      * @throws DatabaseException|InvalidException|InvalidObjectException If fails
      */
     private static function createDatabaseInstance(): object
     {
         switch (parent::getVariables("database.driver")) {
             case "MYSQLI":
                 return new MySqlDriver(self::getDatabaseConfig());
             case "PDO":
             default:
                 return new PdoDriver(self::getDatabaseConfig());
         }
     }
 
     /**
      * Get the database configuration based on environment and settings.
      *
      * @return DatabaseConfig Database configuration object.
      */
     public static function getDatabaseConfig(): DatabaseConfig
     {
         $config = new DatabaseConfig();
         $config->port = parent::getVariables("database.port");
         $config->host = parent::getVariables("database.hostname");
         $config->version = parent::getVariables("database.version");
         $config->charset = parent::getVariables("database.charset");
         $config->sqlite_path = parent::getVariables("database.sqlite.path");
         $config->production = parent::isProduction();
         $config->username = parent::isProduction() ? parent::getVariables("database.username") : parent::getVariables("database.development.username");
         $config->password = parent::isProduction() ? parent::getVariables("database.password") : parent::getVariables("database.development.password");
         $config->database = parent::isProduction() ? parent::getVariables("database.name") : parent::getVariables("database.development.name");
         return $config;
     }
 }
 