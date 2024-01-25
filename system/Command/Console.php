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
use Luminova\Config\Configuration;
use Luminova\Command\Terminal;
use Luminova\Command\Commands;

class Console {
    /**
     * Static terminal instance
     * @var Terminal $instance 
    */
    private static $instance = null;

    /**
     * Initialized terminal instance
     * @var Terminal $cli 
    */
    private $cli;

    /**
     * Is header suppressed?
     * @var bool $suppress 
    */
    private bool $suppress = false;

    /**
     * Initialize console instance
     * 
     * @param bool $suppress Suppress header if no header is detected
    */
    public function __construct(bool $suppress)
    {
        $this->suppress = $suppress;
    }

    /**
     * Get novakit static CLI instance 
     * 
     * @return Terminal
    */
    public static function getTerminal(): Terminal
    {
        if(self::$instance === null){
            self::$instance = new Terminal();
        }
        return self::$instance;
    }

    /**
     * Run CLI
     * @param Terminal $cli novakit cli instance
     * @param callable $callback Optional callback function
     * 
     * @return void
    */
    public function run(Terminal $cli, callable $callback = null): void
    {
        $this->cli = $cli;
        $this->cli::parseCommands($this->cli::parseCommandLine($_SERVER['argv'] ?? []), false);

        if(Commands::hasCommand($this->cli::getCommand())){
            $params  = array_merge($this->cli::getArguments(), $this->cli::getOptions());
            $this->printHeader();
            Commands::run($this->cli, $params);
            if(is_callable($callback)){
                $callback();
            }
        }
    
        exit(1);
    }

    /**
     * Print CLI header
     * 
     * @return void
    */
    private function printHeader(): void
    {
       if ($this->suppress) {
           return;
       }
       $this->cli::header(Configuration::$version);
    }
}
