<?php 
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\Database;
use Luminova\Config\DotEnv;
use Luminova\Config\BaseConfig;

class Conn extends BaseConfig{
    public $db;
    private static $instance;

    public function __construct() 
    {
        $this->db = self::createDatabaseInstance();
		$this->db->setDebug(!parent::isProduction());
    }

    public static function getInstance(): Conn 
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance->db;
    }

    private static function createDatabaseInstance(): object 
    {
        switch (parent::getVariables("database.driver")) {
            case "MYSQLI":
                return new Mysqli(parent::getDatabaseConfig());
            case "PDO":
            default:
                return new Pdo(parent::getDatabaseConfig());
        }
    }
}