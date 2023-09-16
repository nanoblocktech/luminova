<?php 
/**
 * This file is part of Luminova framework.
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */
namespace Luminova\Config;
use Luminova\Exceptions\FileNotFoundException;
class DotEnv {
    public static function register(string $path) {
        if (!file_exists($path)) {
            throw new FileNotFoundException("DotEnv file not found: $path");
        }

        $file = new \SplFileObject($path, 'r');
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