#!/usr/bin/env php
<?php
require_once(__DIR__ . '/system/plugins/autoload.php');

use \Composer\Console\Application;
use Luminova\Arrays\ArrayInput;
use Luminova\Command\AppCommand;
use Luminova\Command\RebuildCommand;
$application = new Application();

// Define your custom command logic here
$application->add(new AppCommand());
$application->add(new RebuildCommand());

// Create an array of parameters
$input = new ArrayInput([
    'command' => 'your-custom-command',
    '--option' => 'option-value',
    'argument1' => 'arg1-value',
]);

$input_build = new ArrayInput([
    'command' => 'rebuild-project-command',
    '--option' => 'option-value',
    'argument1' => 'arg1-value',
]);

$application->run($input);
$application->run($input_build);
