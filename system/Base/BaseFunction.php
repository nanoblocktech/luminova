<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */

namespace Luminova\Base;

use Luminova\Functions\Functions;
use Luminova\Functions\IPAddress;
use Luminova\Functions\Files;
use Luminova\Functions\Document;

abstract class BaseFunction extends Functions
{
    /**
     * @var array $instances Instances of function classes
     */
    private static array $instances = [];

    /**
     * Returns an instance of the Files class.
     *
     * @return Files
     */
    public static function files(): Files
    {
        return self::$instances['Files'] ??= new Files();
    }

    /**
     * Returns an instance of the IPAddress class.
     *
     * @return IPAddress
     */
    public static function ip(): IPAddress
    {
        return self::$instances['IPAddress'] ??= new IPAddress();
    }

    /**
     * Returns an instance of the Document class.
     *
     * @return Document
     */
    public static function document(): Document
    {
        return self::$instances['Document'] ??= new Document();
    }
}