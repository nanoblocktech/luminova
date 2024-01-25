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
use Luminova\Base\BaseCommand;

class Server extends BaseCommand 
{
    /**
     * @var int $portOffset port offset
    */
    private int $portOffset = 0;

    /**
     * @var int $tries number of tries
    */
    private int $tries = 10;

    /**
     * @var string $group command group
    */
    protected string $group = 'Luminova';

    /**
     * @var string $name command name
    */
    protected string $name = 'server';

    /**
     * Options
     *
     * @var array<string, string>
    */
    protected array $options = [
        '--php'  => 'The PHP Binary [default: "PHP_BINARY"]',
        '--host' => 'The HTTP Host [default: "localhost"]',
        '--port' => 'The HTTP Host Port [default: "8080"]',
    ];

    //php novakit server --host localhost --port 3030

    /**
     * @param array $options terminal options
     * 
     * @return int 
    */
    public function run(?array $params = []): int
    {
        // Collect any user-supplied options and apply them.
        $options = $params['options']??[];
        $php  = escapeshellarg($options['php'] ?? PHP_BINARY);
        $host = $options['host'] ?? 'localhost';
        $port = (int) ($options['port'] ?? 8080) + $this->portOffset;

        // Get the party started.
        Terminal::write('Luminova development server started on http://' . $host . ':' . $port, 'green');
        Terminal::newLine();
        Terminal::write('Press Control-C to stop.');
        Terminal::newLine();

        // Set the Front Controller path as Document Root.
        $docRoot = escapeshellarg(PUBLIC_PATH);

        // Mimic Apache's mod_rewrite functionality with user settings.
        $rewrite = escapeshellarg(__DIR__ . '/rewrite.php');

        // Call PHP's built-in webserver, making sure to set our
        // base path to the public folder, and to use the rewrite file
        // to ensure our environment is set and it simulates basic mod_rewrite.
        passthru($php . ' -S ' . $host . ':' . $port . ' -t ' . $docRoot . ' ' . $rewrite, $status);

        if ($status && $this->portOffset < $this->tries) {
            $this->portOffset++;

            $this->run($params);
        }

        return 0;
    }
}