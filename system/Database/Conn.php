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

use Luminova\Config\Configuration;
use Luminova\Database\Drivers\MySqlDriver;
use Luminova\Database\Drivers\PdoDriver;
use Luminova\Config\Database;

 /**
  * Class Conn
  *
  * Manages database connections based on configuration.
  *
  * @package Luminova\Database
  */
 class Conn
 {
     /** 
      * Database connection instance 
      * @var object 
      */
     public $db;
 
     /** @var object|null */
     private static $instance = null;
 
     /**
      * Conn constructor.
      *
      * Initializes the database connection based on configuration.
      * @throws DatabaseException|InvalidException|InvalidObjectException If fails
      */
     public function __construct()
     {
         $this->db = self::createDatabaseInstance();
         $this->db->setDebug(!Configuration::isProduction());
     }
 
     /**
      * Get the singleton instance of Conn.
      *
      * @return object Database connection instance.
      *  @throws DatabaseException|InvalidException|InvalidObjectException If fails
      */

     public static function getInstance(): self {
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
         switch (Configuration::getVariables("database.driver")) {
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
      * @return Database Database configuration object.
      */
     private static function getDatabaseConfig(): Database
     {
         $config = new Database();
         $config->port = Configuration::getVariables("database.port");
         $config->host = Configuration::getVariables("database.hostname");
         $config->version = Configuration::getVariables("database.version");
         $config->charset = Configuration::getVariables("database.charset");
         $config->sqlite_path = Configuration::getVariables("database.sqlite.path");
         $config->production = Configuration::isProduction();
         $config->username = Configuration::isProduction() ? Configuration::getVariables("database.username") : Configuration::getVariables("database.development.username");
         $config->password = Configuration::isProduction() ? Configuration::getVariables("database.password") : Configuration::getVariables("database.development.password");
         $config->database = Configuration::isProduction() ? Configuration::getVariables("database.name") : Configuration::getVariables("database.development.name");
         return $config;
     }
 }
 