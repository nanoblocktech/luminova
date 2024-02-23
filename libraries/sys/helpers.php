<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

$class_configs = include_once(__DIR__ . '/../../class.config.php');

/**
 * Anonymous function to register class aliases
 * 
 * @param array $aliases
 * 
 * @return void 
*/
(function(array $aliases ): void {
    foreach ($aliases as $alias => $namespace) {
        if (!class_alias($namespace, $alias)) {
            logger('warning', "Failed to create an alias [$alias] for class [$namespace]");
        }
    }
})($class_configs['aliases'] ?? []);
