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
use Luminova\Command\TerminalGenerator;
use Luminova\Command\Server;
use Luminova\Command\TextUtils;
class Commands{

    private static $cli = null;
    /**
     * The found commands.
     *
     * @var array
    */
   //php index.php foo -help
   //php index.php foo help

    protected static $commands = [
        'help' => [
            'name' => 'help',
            'usage' => [
                'php index.php <command> <argument> ',
                'php index.php <command> <option> <argument> <option>',
                'php index.php <command> <segment> <argument> <option>',
                'novakit <command> <argument>',
                'novakit <command> <option> <argument> <option>',
                'novakit <command> <segment> <argument> <option>'
            ],
            'description' => "Command helps options for nokakit cli tool.",
            'options' => [
                'foo -help' => 'Show help related to foo command',
                'create:controller userController -extend Controller' => 'Create user controller specifying class and class to extend.',
                'create:controller userController' => 'Create user controller.',
                'create:model userModel -extend userController' => 'Create user model and extend userController.',
                'create:view user' => 'Create user view',
                'create:view user -directory users' => 'Create user view in users directory.',
                'create:class myClass' => 'Create class.',
                'create:class myClass -extend otherClass' => 'Create class specifying class other class to extend.',
                'create:class myClass -extend otherClass -directory myPath' => 'Create class specifying class other class to extend and directory to class.',
                'myControllerClass segment -name Peter -id 1' => 'Query your controller class, pass method as segment and parameter key followed by value.',
            ]
        ],
        'create:controller' => [
            'name' => 'create:controller',
            'usage' => [
                '<command> <argument> <option>',
                '<command> <option>',
                '<command> <argument> <option> <argument> <option>',
            ],
            'description' => "Create a new controller class",
            'options' => [
                'userController -extend Controller' => 'Create user controller specifying class and class to extend.',
                'userController' => 'Create user controller.',
            ]
        ],
        'create:view' => [
            'name' => 'create:view',
            'usage' => [
                '<command> <option> ',
                '<command> <option> <argument>'
            ],
            'description' => "Create a new template view",
            'options' => [
                'user' => 'Create user.php template view.',
                'user -directory user' => 'Create user.php template view in user/ directory.',
            ]
        ],
        'create:class' => [
            'name' => 'create:class',
            'usage' => [
                '<command> <option>',
                '<command> <option> <argument> <option>'
            ],
            'description' => "Create a new controller class",
            'options' => [
                'myClass' => 'Create a new class.',
                'myClass -extend otherClass' => 'Create a new class and extend otherClass.',
                'myClass -extend otherClass -directory myPath' => 'Create a new class and extend otherClass, save in myPath directory.',
            ]
        ],
        'list' => [
            'name' => '',
            'usage' => '',
            'description' => "List available commands.",
            'options' => [

            ]
        ],
        'db:create' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],
        'db:update' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],
        'db:insert' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],
        'db:drop' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],
        'db:delete' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],
        'db:truncate' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],  
        'db:select' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],
        'server' => [
            'name' => '',
            'usage' => '',
            'description' => "Hmmm",
            'options' => [

            ]
        ],
    ];



    public static function run(Terminal $cli, array $options)
    {
        //TerminalGenerator::parseCommands($options);
        static::$cli = $cli;
        $caller = trim($cli->getCommand());

        // Define a command mapping
        $helpCommand = function () {
            static::$cli::printHelp(static::$commands['help']);
        };

        $commandMap = [
            'help' => $helpCommand,
            '-help' => $helpCommand,
            'create:controller' => function () {
                echo "TODO Create a new controller";
            },
            'create:view' => function () {
                echo "TODO Create a new view";
            },
            'create:class' => function () {
                echo "TODO Create a new class";
            },
            'list' => function () {
                static::listCommands();
            },
            'db:create' => function () {
                echo "TODO Database create";
            },
            'db:update' => function () {
                echo "TODO Database update";
            },
            'db:insert' => function () {
                echo "TODO Database insert";
            },
            'db:delete' => function () {
                echo "TODO Database delete";
            },
            'db:drop' => function () {
                echo "TODO Database drop";
            },
            'db:truncate' => function () {
                echo "TODO Database truncate";
            },
            'db:select' => function () {
                echo "TODO Database select";
            },
            'server' => function ($options) {
                (new Server)->run($options);
            },
        ];

        // Check if the command exists in the mapping
        if (array_key_exists($caller, $commandMap)) {
            // Execute the associated action
            $commandMap[$caller]($options);
        } else {
            // Handle unknown command
            echo "Handle Unknown command: $caller\n";
        }
        exit(0);
    }


   
    public function discoverCommands()
    {
        if ($this->commands !== []) {
            return;
        }

        asort($this->commands);
    }

    public static function listCommands()
    {
        static::$cli::writeln('List:');
        static::$cli::newLine();
        foreach (static::$commands as $name => $command) {
            static::$cli::writeln('   ' . static::$cli::color(TextUtils::rightPad($name, 25), 'green') . $command['description']);
        }
        static::$cli::newLine();
    }
    //php index.php list

    public function addCommand($name, $description, $usages)
    {
        $this->commands[$name] = [
            'description' => $description,
            'usages' => $usages,
        ];
    }

    public static function hasCommand(string $command): bool
    {
        return isset(static::$commands[$command]) || $command === '-help';
    }

    public static function getCommand(string $command): array
    {
        return isset(static::$commands[$command]) ? static::$commands[$command] : [];
    }

    public static function get(string $command, $key): array
    {
        return isset(static::$commands[$command][$key]) ? static::$commands[$command][$key] : null;
    }
}