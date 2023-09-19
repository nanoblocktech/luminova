<?php 
namespace Luminova\Config;

class BaseConfig {
    
    public function __construct(){
  
    }

	public static function appName(): string 
    {
        return self::getVariables("app.name");
    }

    public static function hostName(): string 
    {
        return self::getVariables("app.hostname");
    }

    public static function baseUrl(): string 
    {
        return self::url_protocol() . self::getVariables("app.hostname");
    }

    public static function base_www_url(): string 
    {
        return self::url_protocol() . "www." . self::getVariables("app.hostname");
    }

    public static function appVersion(): string 
    {
        return (string) self::getVariables("app.version");
    }

    public static function fileVersion(): string 
    {
        return (string) self::getVariables("app.file.version");
    }

    public static function shouldMinify(): int 
    {
        return (int) self::getVariables("build.minify");
    }

    public static function phpScript(): string 
    {
        return "/usr/bin/php"; ///etc/alternatives/php
    }

    public static function url_protocol(): string 
    {
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    }

    /**
     * Get current page url
     *
     * @param string $url The content to be saved to the cache file.
     */
    public static function getFullUrl(): string {
        return self::url_protocol() . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }

    public static function getRequestHost(): string {
        return self::url_protocol() . $_SERVER['HTTP_HOST'];
    }

    public static function isProduction(){
        return (self::getVariables("app.environment.mood") == "production");
    }

    private static function getDatabaseConfig(): array 
    {
        $config = [
            "PORT" => self::getVariables("database.port"),
            "HOST" => self::getVariables("database.hostname"),
            "VERSION" => self::getVariables("database.version"),
            "CHARSET" => self::getVariables("database.charset"),
			"SQLITE_PATH" => self::getVariables("database.sqlite.path")
        ];
        $config["USERNAME"] = self::isProduction() ? self::getVariables("database.username") : self::getVariables("database.development.username");
        $config["PASSWORD"] = self::isProduction() ? self::getVariables("database.password") : self::getVariables("database.development.password");
        $config["NAME"] = self::isProduction() ? self::getVariables("database.name") : self::getVariables("database.development.name");
        return $config;
    }
   
    public static function getVariables(string $key, mixed $default = null): mixed 
    {
        //$underscoreProperty = str_replace('.', '_', $property);
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
}