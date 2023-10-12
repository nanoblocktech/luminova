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

class BaseConfig {
    protected static array $allowPreviews = ['system', 'app', 'resources', 'writable'];

    /**
     * Magic method to retrieve session properties.
     *
     * @param string $propertyName The name of the property to retrieve.
     * @return mixed
     */
    public function __get(string $propertyName): mixed {
        $data = self::getVariables($propertyName);

        if ($data === null) {
            $data = self::getVariables(self::variableToNotation($propertyName, ".")) ?? self::getVariables(self::variableToNotation($propertyName, "_")) ?? "";
        }

        return $data;
    }


    /**
     * Get the application name.
     *
     * @return string
     */
    public static function appName(): string 
    {
        return self::getVariables("app.name");
    }

    /**
     * Get the host name.
     *
     * @return string
     */
    public static function hostName(): string 
    {
        return self::getVariables("app.hostname");
    }

    /**
     * Get the base URL.
     *
     * @return string
     */
    public static function baseUrl(): string 
    {
        return self::getVariables("app.base.url");
    }

    /**
     * Get the base www URL.
     *
     * @return string
     */
    public static function baseWwwUrl(): string 
    {
        return self::getVariables("app.base.www.url");
    }

    /**
     * Get the application version.
     *
     * @return string
     */
    public static function appVersion(): string 
    {
        return (string)self::getVariables("app.version");
    }

    /**
     * Get the file version.
     *
     * @return string
     */
    public static function fileVersion(): string 
    {
        return (string)self::getVariables("app.file.version");
    }

    /**
     * Check if minification is enabled.
     *
     * @return int
     */
    public static function shouldMinify(): int 
    {
        return (int)self::getVariables("build.minify");
    }

    /**
     * Get the PHP script path.
     *
     * @return string
     */
    public static function phpScript(): string 
    {
        return "/usr/bin/php"; // /etc/alternatives/php
    }

    /**
     * Get the URL protocol (http or https).
     *
     * @return string
     */
    public static function urlProtocol(): string 
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    }

    /**
     * Get the full URL.
     *
     * @return string
     */
    public static function getFullUrl(): string {
        return self::urlProtocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    /**
     * Get the request host.
     *
     * @return string
     */
    public static function getRequestHost(): string {
        return self::urlProtocol() . $_SERVER['HTTP_HOST'];
    }

    /**
     * Check if the application is in production mode.
     *
     * @return bool
     */
    public static function isProduction(): bool
    {
        return (self::getVariables("app.environment.mood") == "production");
    }

    /**
     * Check if the application is running locally.
     *
     * @return bool
     */
    public static function isLocal(): bool
    {
        return ($_SERVER['SERVER_NAME'] === "localhost");
    }

    /**
     * Get the root directory.
     *
     * @param string $directory The directory to start searching for composer.json.
     * @return string|null
     */
    public static function getRootDirectory(string $directory)
    {
        $currentDirectory = $directory;

        while (!file_exists($currentDirectory . '/composer.json')) {
            $parentDirectory = dirname($currentDirectory);

            if ($parentDirectory === $currentDirectory) {
                return null; 
            }

            $currentDirectory = $parentDirectory;
        }

        return $currentDirectory;
    }

    /**
     * Filter the path to match allowed directories.
     *
     * @param string $path The path to be filtered.
     * @return string
     */
    public static function filterPath(string $path): string {
        $matchingDirectory = '';

        foreach (self::$allowPreviews as $directory) {
            $directoryWithSlash = $directory . '/';
            if (strpos($path, $directoryWithSlash) !== false) {
                $matchingDirectory = $directoryWithSlash;
                break;
            }
        }

        if ($matchingDirectory) {
            $resultingPath = substr($path, strpos($path, $matchingDirectory));
            return $resultingPath;
        } else {
            return basename($path);
        }
    }

    /**
     * Get configuration variables.
     *
     * @param string $key The key to retrieve.
     * @param mixed $default The default value to return if the key is not found.
     * @return mixed
     */
    public static function getVariables(string $key, mixed $default = null): mixed 
    {
        if (getenv($key) !== false) {
            return getenv($key);
        }

        if (!empty($_ENV[$key])) {
            return $_ENV[$key];
        }

        if (!empty($_SERVER[$key])) {
            return $_SERVER[$key];
        }

        return $default;
    }

    /**
     * Convert variable to dot or underscore notation.
     *
     * @param string $input The input string .
     * @param string $notation The conversion notion
     * @return string
     */

    public static function variableToNotation(string $input, string $notation = "."): string {
        if ($notation === ".") {
            $output = str_replace('_', '.', $input);
        } elseif ($notation === "_") {
            $output = str_replace('.', '_', $input);
        } else {
            return $input; 
        }
    
        if ($notation === ".") {
            $output = preg_replace('/([a-z0-9])([A-Z])/', '$1.$2', $output);
        } elseif ($notation === "_") {
            $output = preg_replace('/([a-z0-9])([A-Z])/', '$1_$2', $output);
        }
    
        // Remove leading dot or underscore (if any)
        $output = ltrim($output, $notation);
    
        return $notation === "_" ? strtoupper($output) : strtolower($output);
    }
}
