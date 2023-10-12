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

/**
 *
 * @author Peter Chigozie(NG) peterujah
 * @copyright Copyright (c), 2021 Peter(NG) peterujah
 * @license MIT public license
 */
class Optimizer
{
    /**
     * @var string $cacheDir The directory where cached files will be stored.
     */
    private string $cacheDir;

    /**
     * @var int $cacheExpiration The expiration time for cached 
     */
    private int $cacheExpiration;

    /**
     * @var string $optimizerKey Cache key
     */
    private string $optimizerKey;

    /**
     * Class constructor.
     *
     * @param int $cacheExpiration The expiration time for cached files in seconds (default: 24 hours).
     * @param string $cacheDir The directory where cached files will be stored (default: 'cache').
     */
    public function __construct(int $cacheExpiration = 24 * 60 * 60, string $cacheDir = 'cache')
    {
        $this->cacheDir = $cacheDir;
        $this->cacheExpiration = $cacheExpiration;
    }

    /**
     * Get the file path for the cache based on the current request URI.
     *
     * @return string The file path for the cache.
     */
    public function getCacheLocation(): string
    {
        return $this->getCacheFilepath() . $this->getKey() . '.html';
    }

    /**
     * Get the cache directory path.
     *
     * @return string The cache directory path.
     */
    public function getCacheFilepath(): string
    {
        return rtrim($this->cacheDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    /**
     * Check if the cached file is still valid based on its expiration time.
     *
     * @return bool True if the cache is still valid; false otherwise.
     */
    public function hasCache(): bool
    {
        return file_exists($this->getCacheLocation()) &&
            time() - filemtime($this->getCacheLocation()) < $this->cacheExpiration;
    }

    /**
     * Get the formatted file modification time.
     *
     * @return string Formatted file modification time.
     */
    public function getFileTime(): string
    {
        $timestamp = filemtime($this->getCacheLocation());
        return date('D jS M Y H:i:s', $timestamp);
    }

    /**
     * Load the content from the cache file and exit the script.
     *
     * @return bool True if loading was successful; false otherwise.
     */
    public function getCache(): bool
    {
        header('X-Powered-By: Luminova');
        $bytesRead = readfile($this->getCacheLocation());
        return $bytesRead !== false;
    }

    /**
     * Save the content to the cache file.
     *
     * @param string $content The content to be saved to the cache file.
     *
     * @return bool True if saving was successful; false otherwise.
     */
    public function saveCache(string $content): bool
    {
        if (!file_exists($this->getCacheFilepath())) {
            mkdir($this->getCacheFilepath(), 0755, true);
        }

        $bytesWritten = file_put_contents($this->getCacheLocation(), $content);
        return $bytesWritten !== false;
    }

    /**
     * Get the cache key.
     *
     * @return string The cache key.
     */
    public function getKey(): string
    {
        return $this->optimizerKey;
    }

    /**
     * Set the cache key.
     *
     * @param string $key The key to set.
     *
     * @return void
     */
    public function setKey(string $key): void
    {
        $this->optimizerKey = md5($key);
    }
}
