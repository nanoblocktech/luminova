<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Cache;
use \Luminova\Cache\BaseFileCache;

class FileCache extends BaseFileCache {

    public const TTL_7DAYS = 7 * 24 * 60 * 60;
    public const TTL_24HR = 24 * 60 * 60;
    public const TTL_30MIN = 30 * 60;
    //dirname(__DIR__)

    public function __construct() {}

    /**
     * Check if the server is running locally.
     *
     * @return bool True if running locally, false otherwise.
     */
    private static function isLocal(): bool {
        return ($_SERVER['SERVER_NAME'] == "localhost");
    }

    /**
     * Get storage paths for cache.
     *
     * @param string $root The root directory.
     * @param string|null $subPaths Subdirectories within the root directory (optional).
     * @param int $level The level of the path (optional).
     * @return array An array containing the root and storage paths.
     */
    public static function getStorage(string $root, ?string $subPaths = '', int $level = 2): array {
        $rootDir = trim($root, DIRECTORY_SEPARATOR);
        if (!empty($subPaths)) {
            $subPaths = trim($subPaths);
            $subPaths .= DIRECTORY_SEPARATOR;
        }

        return [
            $rootDir,
            self::localPath($level). $rootDir . DIRECTORY_SEPARATOR . $subPaths,
        ];
    }

    /**
     * Get the local path.
     *
     * @param int $level The level of the path (optional).
     * @return string The local path.
     */
    private static function localPath(int $level = 1): string {
        $path = self::pathLevel($level);
        $path = sprintf('writeable%1$scaches%1$s', DIRECTORY_SEPARATOR);
        return $path;
    }

    /**
     * Get the path level.
     *
     * @param int $level The level of the path (optional).
     * @return string The path level.
     */
    private static function pathLevel(int $level): string {
        $path = str_repeat(DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR, $level);
        $path = preg_replace('#/{2,}#', DIRECTORY_SEPARATOR, $path);
        return rtrim($path, DIRECTORY_SEPARATOR);
    }

    /**
     * Set the storage location and configuration.
     *
     * @param string $name The name of the storage.
     * @param string|null $subPaths Subdirectories within the storage (optional).
     * @param int $level The level of the path (optional).
     * @return FileCache The current FileCache instance.
     */
    public function storage(string $name, ?string $subPaths = '', int $level = 1): FileCache {
        $this->setFilename($name);
        $this->setCacheLocation(".." . DIRECTORY_SEPARATOR . self::getStorage($name, $subPaths, $level)[1]);
        $this->addConfig();
        return $this;
    }

    /**
     * Set the storage location and configuration.
     *
     * @param string $name The name of the storage.
     * @param string $path The path to the storage.
     * @return FileCache The current FileCache instance.
     */
    public function storagePath(string $name, string $path): FileCache {
        $this->setFilename($name);
        $this->setCacheLocation($path);
        $this->addConfig();
        return $this;
    }

    /**
     * Add cache configuration.
     *
     * @param string $type The cache file extension type (optional).
     * @param int $expiry The cache expiry time in seconds (optional).
     * @return void
     */
    private function addConfig(string $type = parent::JSON, int $expiry = self::TTL_24HR): void {
        $this->setExtension($type);
        $this->setDebugMode(self::isLocal());
        $this->enableDeleteExpired(true);
        $this->setExpire($expiry);
        $this->initializeEngine();
    }
}