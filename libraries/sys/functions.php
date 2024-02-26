<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
use Luminova\Application\Services;
use \Luminova\Http\Request;
use \Luminova\Logger\NovaLogger;
use \Luminova\Cookies\Cookie;

if(!function_exists('env')){
    /**
     * Get environment variables.
     *
     * @param string $key The key to retrieve.
     * @param mixed $default The default value to return if the key is not found.
     * 
     * @return mixed
     */
    function env(string $key, mixed $default = null): mixed 
    {
        if (getenv($key) !== false) {
            $env = getenv($key);
        }elseif (isset($_ENV[$key])) {
            $env = $_ENV[$key];
        }elseif (isset($_SERVER[$key])) {
            $env = $_SERVER[$key];
        }

        return $env ?? $default;
    }
}

if(!function_exists('setenv')){
    /**
     * Set an environment variable if it doesn't already exist.
     *
     * @param string $key The key of the environment variable.
     * @param string $value The value of the environment variable.
     * 
     * @return void
     */
    function setenv(string $key, string $value): void
    {
        if (!getenv($key, true)) {
            putenv("{$key}={$value}");
        }

        if (empty($_ENV[$key])) {
            $_ENV[$key] = $value;
        }

        if (empty($_SERVER[$key])) {
            $_SERVER[$key] = $value;
        }
    }
}
      

if(!function_exists('locale')){
    /**
    * Set locale or return local 
    *
    * @param ?string $locale If locale is present it will set it else return default locale
    *
    * @return string|bool;
    */
   function locale(?string $locale = null): string|bool 
   {
        if($locale === null){
            $locale = env('app.locale', 'en');

            return $locale;
        }else{
            setenv('app.locale', $locale);
        }

        return true;
   }
}

if(!function_exists('func')){
    /**
    * Return BaseFunction instance
    *
    * @param string $context If context is present return instance of specified context else return 
    *          BaseFunction instance or null ['files', 'ip', 'document', 'escape']
    * @param mixed ...$params
    *
    * @throws Exception;
    * @throws RuntimeException;
    */
   function func(?string $context = null, ...$params): mixed 
   {
        $func = Services::functions();

        if($context === null){
            return $func;
        }
        $context = strtolower($context);

        if(in_array($context, ['files', 'ip', 'document', 'escape'], true)){
            return $func::{$context}(...$params);
        }

        return null;
   }
}

if(!function_exists('escape')){
    /**
    * Escapes a string or array of strings based on the specified context.
    *
    * @param string|array $input The string or array of strings to be escaped.
    * @param string $context The context in which the escaping should be performed. Defaults to 'html'.
    *                        Possible values: 'html', 'js', 'css', 'url', 'attr', 'raw'.
    * @param string|null $encoding The character encoding to use. Defaults to null.
    * 
    * @return mixed The escaped string or array of strings.
    * @throws InvalidArgumentException When an invalid escape context is provided.
    * @throws Exception;
    * @throws RuntimeException;
    */
   function escape(string|array $input, string $context = 'html', ?string $encoding = null): mixed 
   {
       $func = Services::functions();

       return $func::escape($input, $context, $encoding);
   }
}

if(!function_exists('session')) {
    /**
     * Return session data if key is present else return session instance
     *
     * @param string $key 
     *
     * @return mixed
     */
    function session(?string $key = null)
    {
        $session = Services::session();

        if (is_string($key) && $key !== '') {
            return $session->get($key);
        }

        return $session;
    }
}

if (!function_exists('cookie')) {
    /**
     * Create Cookie instance.
     *
     * @param string $name Name of the cookie
     * @param string $value Value of the cookie
     * @param array  $options Options to be passed to the cookie
     * 
     */
    function cookie(string $name, string $value = '', array $options = []): Cookie
    {
        return new Cookie($name, $value, $options);
    }
}

if(!function_exists('service')) {
    /**
     * Returns a shared instance of the class
     *
     * Same as:
     * @example $config = service('config')
     * @example $config = \Luminova\Application\Services::config();
     * @example $config = new \Luminova\Config\Configuration();
     * 
     * @param string $context The class name to load
     * @param mixed ...$params
     * 
     * @return object|null 
     */
    function service(string $context, ...$params): ?object
    {
        return Services::$context(...$params);
    }
}

if(!function_exists('browser')) {
    /**
     * Tells what the user's browser is capable of
     * 
     * @param string|null $user_agent
     * @param bool $return_array If set to true, this function will return an array instead of an object.
     * 
     * @return array|object
     */
    function browser(?string $user_agent = null, bool $return_array = false): array|object 
    { 
        if (ini_get('browscap')) {
            $browser = get_browser($user_agent, $return_array);
            
            if ($browser !== false) {
                return $browser;
            }
        }

        $browser =  Request::parseUserAgent($user_agent, $return_array);

        return $browser;
    }
}

if (!function_exists('text2html')) {
    /**
     * Converts text characters in a string to HTML entities. 
     * This is useful when you want to display text in an HTML textarea while preserving the original line breaks.
     * 
     * @param string $text A string containing the text to be processed.
     * 
     * @return string $text The processed text with HTML entities.
     */
    function text2html(?string $text): string
    { 
        if ($text === null ||  $text === '') {
            return '';
        }

        $text = htmlspecialchars($text, ENT_QUOTES | ENT_HTML5);

        return $text;
    }
}

if(!function_exists('nl2html')) {
    /**
     * Converts newline characters in a string to HTML entities. 
     * This is useful when you want to display text in an HTML textarea while preserving the original line breaks.
     * 
     * @param string $text A string containing the text to be processed.
     * 
     * @return string $text
     */
    function nl2html(?string $text): string
    { 
        if($text === null ||  $text === ''){
            return '';
        }

        $text = str_replace(["\n", "\r\n", '[br/]', '<br/>'], "&#13;&#10;", $text);
        $text = str_replace(["\t"], "&#09;", $text);

        return $text;
    }
}

if(!function_exists('import')) {
    /**
      * Import a custom library into your project 
      * You must place your external libraries in libraries/libs/ directory
      * 
      * @param string $library the name of the library
      * @example Foo/Bar/Baz
      * @example Foo/Bar/Baz.php
      * 
      * @return bool true if the library was successfully imported
      * @throws RuntimeException if library could not be found
     */
     function import(string $library): bool
     {
         $instance = Services::import();
         $import = $instance::import($library);
 
         return $import;
     }
 }


 if(!function_exists('logger')) {
    /**
     * Log a message at the given level.
     *
     * @param string $level The log level.
     * - Log levels ['emergency, alert, critical, error, warning, notice, info, debug, exception, php_errors']
     * @param string $message The log message.
     * @param array $context Additional context data (optional).
     *
     * @return void
     */
     function logger(string $level, string $message, array $context = []): void
     {
        (new NovaLogger())->log($level, $message, $context);
     }
 }

 if (!function_exists('lang')) {
    /**
     * Translate multiple languages it supports nested array
     *
     * @param string $lookup line to lookup
     * @param string $default Fallback translation if not found
     * @param array $placeholders Matching placeholders for translation
     *    - @example array ['Peter', 'peter@foo.com] "Error name {0} and email {1}"
     *    - @example array ['name' => 'Peter', 'email' => 'peter@foo.com] "Error name {name} and email {email}"
     * @param ?string $locale
     * 
     * @return string $translation
     * @throws Exception if translation is not found and default is not provided
     */
    function lang(
        string $lookup, 
        string $default = '', 
        array $placeholders = [], 
        ?string $locale = null
    ): string
    {
        $language = Services::language();

        $defaultLocal = $language->getLocale();

        if ($locale && $locale !== $defaultLocal) {
            $language->setLocale($locale);
        }

        $translation = $language->get($lookup, $default, $placeholders);

        if ($locale && $locale !== $defaultLocal) {
            $language->setLocale($defaultLocal);
        }

        return $translation;
    }
}

if (!function_exists('root')) {
    /**
     * Get the root directory.
     *
     * @param string $directory The directory to start searching for composer.json or system directory.
     * 
     * @return string
     */
    function root(string $directory = __DIR__, string $suffix = ''): string
    {
        $path = realpath($directory);

        if ($path === false) {
            return $suffix; 
        }

        do {
            if (file_exists($path . DIRECTORY_SEPARATOR . 'composer.json')) {
                if(str_starts_with($suffix, DIRECTORY_SEPARATOR)){
                    return $path . $suffix;
                }

                return $path . DIRECTORY_SEPARATOR . $suffix;
            }
            
            $parent = dirname($path);
            if ($parent === $path) {
                return $suffix;
            }

            $path = $parent;
        } while (true);
    }
}