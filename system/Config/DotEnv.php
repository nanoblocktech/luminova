<?php 
namespace Luminova\Config;
class DotEnv {
    public static function register(string $path) {
        if (!file_exists($path)) {
            throw new Exception("DotEnv file not found: $path");
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (strpos(trim($line), '#') === 0) {
                continue;
            }
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);
                self::setVariable($name, $value);
            }
        }
    }


    protected static function setVariable(string $name, string $value = ''){
        if (! getenv($name, true)) {
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