<?php
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Arrays;
use \Countable;
class ArrayCountable implements Countable {
    /**
     * @var array
    */
    private $array = [];

    /**
    * @param array $array
    */
    public function __construct(array $array) {
        $this->array = $array;
    }

    /**
    * @return int array count
    */
    public function count(): int {
        return count($this->array);
    }
}
