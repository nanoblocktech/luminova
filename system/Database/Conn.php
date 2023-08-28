<?php 
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\DatabaseManager;
use Luminova\Config\DotEnv;

class Conn {
    public $db;
    private static $instance;

    public function __construct() {
        $this->db = self::createDatabaseInstance();
		$this->db->setDebug(!self::getVariables("app.production.mood"));
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance->db;
    }

    private static function createDatabaseInstance() {
        switch (self::getVariables("database.driver")) {
            case "MYSQLI":
                return new MysqliDriver(self::getDatabaseConfig());
            case "PDO":
            default:
                return new PDODriver(self::getDatabaseConfig());
        }
    }

    private static function getDatabaseConfig() {
        $config = [
            "PORT" => self::getVariables("database.port"),
            "HOST" => self::getVariables("database.hostname"),
            "VERSION" => self::getVariables("database.version"),
            "CHARSET" => self::getVariables("database.charset"),
			"SQLITE_PATH" => self::getVariables("database.sqlite.path")
        ];
        $env = self::getVariables("app.production.mood");
        $config["USERNAME"] = $env ? self::getVariables("database.username") : self::getVariables("database.development.username");
        $config["PASSWORD"] = $env ? self::getVariables("database.password") : self::getVariables("database.development.password");
        $config["NAME"] = $env ? self::getVariables("database.name") : self::getVariables("database.development.name");
        return $config;
    }

    private static function getVariables($key) {
        if (getenv($key) !== false) {
            return getenv($key);
        }

        if (!empty($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (!empty($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return null;
    }
}