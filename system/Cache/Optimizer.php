<?php
namespace Luminova\Cache;
/**
 * OBCompress - A simple php class to optimize php page performance
 * @author      Peter Chigozie(NG) peterujah
 * @copyright   Copyright (c), 2021 Peter(NG) peterujah
 * @license     MIT public license
 */
class Optimizer {
    /**
     * @var string $cacheDir The directory where cached files will be stored.
     */
    private $cacheDir;

    /**
     * @var int $cacheExpiration The expiration time for cached files in seconds (default: 600 seconds, i.e., 10 minutes).
     */
    private $cacheExpiration;

    /**
     * Class constructor.
     *
     * @param int $cacheExpiration The expiration time for cached files in seconds (default: 600 seconds, i.e., 10 minutes).
     * @param string $cacheDir The directory where cached files will be stored (default: 'cache').
     */
    public function __construct(int $cacheExpiration = 60 * 60 * 24, string $cacheDir = 'cache') {
        $this->cacheDir = $cacheDir;
        $this->cacheExpiration = $cacheExpiration;
    }

    /**
     * Get the file path for the cache based on the current request URI.
     *
     * @return string The file path for the cache.
     */
    public function getCacheLocation(): string {
        return rtrim($this->cacheDir, "/") . '/' . md5($this->getUrl()) . '.html';
    }

    public function getCacheFilepath(): string {
        return rtrim($this->cacheDir, "/") . '/';
    }

    /**
     * Check if the cached file is still valid based on its expiration time.
     *
     * @param string $cacheFile The path to the cached file.
     * @return bool True if the cache is still valid; false otherwise.
     */
    public function isCacheValid(string $cacheFile): bool {
        return file_exists($cacheFile) && time() - filemtime($cacheFile) < $this->cacheExpiration;
    }

    /**
     * Load the content from the cache file and exit the script.
     *
     * @param string $cacheFile The path to the cached file.
     */
    public function loadFromCache(string $cacheFile): void {
        @readfile($cacheFile);
        exit;
    }

    /**
     * Save the content to the cache file.
     *
     * @param string $cacheFile The path to the cached file.
     * @param string $content The content to be saved to the cache file.
     * @return string The cached content
     */
    public function saveToCache(string $cacheFile, string $content): string {
        if (!@file_exists($this->getCacheFilepath())){
			@mkdir($this->getCacheFilepath(), 0755, true);
		}
        @file_put_contents($cacheFile, $content);
        return $content;
    }

    /**
     * Get current page url
     *
     * @return string The content to be saved to the cache file.
     */
    private function getUrl(): string {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
}