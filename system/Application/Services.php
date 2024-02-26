<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Application;

use \Luminova\Config\Configuration;
use \Luminova\Time\Task;
use \Luminova\Functions\Functions;
use \Luminova\Functions\IPAddress;
use \Luminova\Functions\Files;
use \Luminova\Functions\Document;
use \Luminova\Sessions\Session;
use \Luminova\Library\Importer;
use \Luminova\Languages\Translator;
use \RuntimeException;
use \Throwable;

/**
 * Services Configuration file.
 *
 * @method static Functions           functions(...$params, bool $shared = true)
 * @method static Functions           func(...$params, bool $shared = true)
 * @method static Configuration       config(...$params, bool $shared = true)
 * @method static Session             session(...$params, bool $shared = true)
 * @method static Task                task(...$params, bool $shared = true)
 * @method static Importer            import(...$params, bool $shared = true)
 * @method static Translator          language($locale, bool $shared = true)
 * @method static $context            $context(...$params, bool $shared = true)
 */


class Services 
{
    /**
     * Cached instances of service classes.
     *
     * @var array
     */
    private static $instances = [];

    /**
     * Get the fully qualified class name of the service based on the provided context.
     *
     * @param string $context The context or name of the service.
     * 
     * @return string|null The fully qualified class name of the service, or null if not found.
     */
    private static function get(string $context): ?string
    {
        $context = strtolower($context);

        return match($context) {
            'task' => Task::class,
            'config' => Configuration::class,
            'session' => Session::class,
            'func', 'functions' => Functions::class,
            'ip' => IPAddress::class,
            'file' => Files::class,
            'document' => Document::class,
            'import' => Importer::class,
            'language' => Translator::class,
            default => null
        };
    }

    /**
     * Dynamically create an instance of the specified service class.
     *
     * @param string $context The context or name of the service.
     * @param mixed ...$params Parameters to pass to the service constructor.
     * @param bool $shared The Last parameter to pass to the service constructor 
     * indicate if it should return a shared instance
     * 
     * @example Services::method('foo', 'bar', false)
     * @example Services::method(false)
     * 
     * @return object|null An instance of the service class, or null if not found.
     * @throws RuntimeException If failed to instantiate the service.
     */
    public static function __callStatic($context, $arguments): ?object
    {
        $shared = true; 

        if (self::get($context) === null) {
            throw new RuntimeException("Service '$context' not found.");
        }

        // If the last argument is provided and it's a boolean, use it as the shared flag
        if (isset($arguments[count($arguments) - 1]) && is_bool($arguments[count($arguments) - 1])) {
            $shared = array_pop($arguments);
        }

        return self::create($context, $shared, ...$arguments);
    }

    /**
     * Create an instance of the specified service class.
     *
     * @param string $context The context or name of the service.
     * @param bool $shared Whether the instance should be shared (cached) or not.
     * @param mixed ...$params Parameters to pass to the service constructor.
     * 
     * @return object|null An instance of the service class, or null if not found.
     * @throws RuntimeException If failed to instantiate the service.
     */
    public static function create(string $context, bool $shared = true, ...$params): ?object
    {
        $className = self::get($context);
        $instance = null;

        if ($className === null) {
            return null;
        }

        if ($shared && isset(self::$instances[$className])) {
            return self::$instances[$className];
        }
  
        try {
            $instance = new $className(...$params);

            if ($shared) {
                self::$instances[$className] = $instance;
            }
        } catch (Throwable $e) {
            throw new RuntimeException("Failed to instantiate service '$context'. Error: " . $e->getMessage());
        }

        return $instance;
    }

    /**
     * Check if class is available in services
     *
     * @param string $context The context or name of the service.
     * 
     * @return bool 
     */
    private static function has(string $context): bool
    {
        $context = self::get($context);

        return $context !== null;
    }

    /**
     * Clear cached instances of service classes.
     *
     * @param string|null $context Optional. The context or name of the service to clear cache for.
     *                             If null, clears cache for all services.
     * @return void
     */
    public static function remove(?string $context = null): void
    {
        if ($context === null) {
            self::rest();
        }

        $className = self::get($context);
        if ($className !== null) {
            unset(self::$instances[$className]);
        }
    }

    /**
     * Clear all cached instances of service classes.
     *
     * @return void
     */
    public static function rest(): void
    {
        self::$instances = [];
    }
}