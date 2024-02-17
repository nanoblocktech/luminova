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

!defined('APP_COMMON') || define('APP_COMMON', true);

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