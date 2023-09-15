<?php 
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\DatabaseManager;
use Luminova\Config\DotEnv;
use Luminova\Config\ConfigManager;

class Conn extends ConfigManager{
    public $db;
    private static $instance;

    public function __construct() {
        $this->db = self::createDatabaseInstance();
		$this->db->setDebug(!parent::getVariables("app.production.mood"));
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance->db;
    }

    private static function createDatabaseInstance() {
        switch (parent::getVariables("database.driver")) {
            case "MYSQLI":
                return new MysqliDriver(self::getDatabaseConfig());
            case "PDO":
            default:
                return new PDODriver(self::getDatabaseConfig());
        }
    }

    private static function getDatabaseConfig() {
        $config = [
            "PORT" => parent::getVariables("database.port"),
            "HOST" => parent::getVariables("database.hostname"),
            "VERSION" => parent::getVariables("database.version"),
            "CHARSET" => parent::getVariables("database.charset"),
			"SQLITE_PATH" => parent::getVariables("database.sqlite.path")
        ];
        $env = parent::getVariables("app.production.mood");
        $config["USERNAME"] = $env ? parent::getVariables("database.username") : parent::getVariables("database.development.username");
        $config["PASSWORD"] = $env ? parent::getVariables("database.password") : parent::getVariables("database.development.password");
        $config["NAME"] = $env ? parent::getVariables("database.name") : parent::getVariables("database.development.name");
        return $config;
    }
}