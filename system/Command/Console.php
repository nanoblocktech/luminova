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

class Console 
{
    /**
     * Static terminal instance
     * @var Terminal $instance 
    */
    private static $instance = null;

    /**
     * Is header suppressed?
     * @var bool $suppress 
    */
    private bool $noHeader = false;

    /**
     * Initialize console instance
     * 
     * @param bool $suppress Suppress header if no header is detected
    */
    public function __construct(bool $noHeader)
    {
        $this->noHeader = $noHeader;
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
     * @param array $commands commands to execute
     * 
     * @return void
    */
    public function run(array $commands): void
    {
        $result = 1;
        $cli = static::getTerminal();
        $commands = $cli::parseCommands($commands);
        $cli::registerCommands($commands, false);
        $command = $cli::getCommand();
        if (!$this->noHeader) {
            $cli::header(Configuration::$version);
        }

        if('--version' === $command){
            $cli::writeln('Novakit Command Line Tool');
            $cli::writeln('version: ' . Configuration::$version, 'green');
            exit(0);
        }

        $params  = array_merge($cli::getArguments(), $cli::getQueries());
        
        $result = Commands::run($cli, $params);

        exit($result);
    }
}
