<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Models;

/**
 * Database Configuration
 *
 * This class represents the configuration for a database connection.
 */
class DatabaseConfig
{
    /**
     * @var int|null $port The port to connect to the database.
     */
    public ?int $port = 3306;

    /**
     * @var string $host The hostname or IP address of the database server.
     */
    public string $host = 'localhost';

    /**
     * @var string|null $version The version of the database server.
     */
    public ?string $version = 'mysql';

    /**
     * @var string $charset The character set used for the database connection.
     */
    public string $charset = 'utf8';

    /**
     * @var string|null $sqlite_path The path to the SQLite database file if applicable.
     */
    public ?string $sqlite_path = '';

    /**
     * @var bool $production Indicates if this configuration is for a production environment.
     */
    public bool $production = false;

    /**
     * @var string $username The username for the database connection.
     */
    public string $username = '';

    /**
     * @var string $password The password for the database connection.
     */
    public string $password = '';

    /**
     * @var string $database The name of the database to connect to.
     */
    public string $database = '';
}