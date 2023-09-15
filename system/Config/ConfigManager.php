<?php 
namespace Luminova\Config;
class ConfigManager {
    
    public function __construct(){

    }
	public static function appName(){
        return self::getVariables("app.name");
    }

    public static function hostName(){
        return self::getVariables("app.hostname");
    }

    public static function baseUrl(){
        return self::url_protocol() . self::getVariables("app.hostname");
    }

    public static function base_www_url(){
        return self::url_protocol() . "www." . self::getVariables("app.hostname");
    }

    public static function appVersion(){
        return self::getVariables("app.version");
    }

    public static function fileVersion(){
        return self::getVariables("app.file.version");
    }

    public static function minify(){
        return self::getVariables("build.minify");
    }

    public static function phpScript(){
        return "/usr/bin/php"; ///etc/alternatives/php
    }

    public static function url_protocol(){
        return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https://" : "http://";
    }
   
    public static function getVariables($key, $default = null) {
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