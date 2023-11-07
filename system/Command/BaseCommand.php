<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace Luminova\Command;
use Luminova\Command\Terminal;
abstract class BaseCommand extends Terminal {

    protected string $group = '';
    protected string $name = '';
    protected string|array $usage = '';
    protected array $options = [];
    protected string $description = '';

    /**
     * Run a command.
     *
     * @param mixed, string|null> $params
     * 
     * @return int status code 1 or 0
     */
    abstract public function run(?array $params = []): int;

    public function __get(string $key): mixed
    {
        return $this->{$key} ?? null;
    }
    
    public function __isset(string $key): bool
    {
        return isset($this->{$key});
    }
}