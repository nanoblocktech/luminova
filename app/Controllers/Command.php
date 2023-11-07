<?php 
/**
 * Luminova Framework
 *
 * @package Luminova
 * @author Ujah Chigozie Peter
 * @copyright (c) Nanoblock Technology Ltd
 * @license See LICENSE file
 */
namespace App\Controllers;
use Luminova\Command\BaseCommand;
class Command extends BaseCommand {

    protected string $group = 'custom';
    protected string $name  = 'command';
    protected string|array $usages  = 'php index.php command';
    protected string $description = 'Print command options';
    protected array $options = [];


    public function run(?array $params = []): int
    {
        var_export($this->getOptions());
        $this->newLine();
        return parent::STATUS_OK;

    }
    
}