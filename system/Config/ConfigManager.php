<?php 
namespace Luminova\Config;
class ConfigManager {
    
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

    public static function minify(): int 
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
}