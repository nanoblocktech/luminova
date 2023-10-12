<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Config;

use Luminova\Exceptions\FileException;
use SplFileObject;

class DotEnv
{
    /**
     * Register environment variables from a .env file.
     *
     * @param string $path The path to the .env file.
     * @throws FileException If the .env file is not found.
     */
    public static function register(string $path): void
    {
        if (!file_exists($path)) {
            throw new FileException("DotEnv file not found: $path");
        }

        $file = new SplFileObject($path, 'r');
        while (!$file->eof()) {
            $line = trim($file->fgets());
            if (strpos($line, '#') === 0 || strpos($line, ';') === 0) {
                continue;
            }

            $parts = explode('=', $line, 2);
            if (count($parts) >= 2) {
                [$name, $value] = $parts;
                $name = trim($name);
                $value = trim($value);
                self::setVariable($name, $value);
            }
        }
    }

    /**
     * Set an environment variable if it doesn't already exist.
     *
     * @param string $name The name of the environment variable.
     * @param string $value The value of the environment variable.
     */
    protected static function setVariable(string $name, string $value): void
    {
        if (!getenv($name, true)) {
            putenv("{$name}={$value}");
        }

        if (empty($_ENV[$name])) {
            $_ENV[$name] = $value;
        }

        if (empty($_SERVER[$name])) {
            $_SERVER[$name] = $value;
        }
    }
}