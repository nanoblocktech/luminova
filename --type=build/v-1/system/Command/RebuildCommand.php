<?php
namespace Luminova\Command;
use Composer\Composer;
use Composer\Command\BaseCommand;
use Composer\IO\IOInterface;

class RebuildCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('rebuild-project-command')
            ->setDescription('Description of your custom command');
    }


    protected function execute(IOInterface $io): int
    {
        $input = $_SERVER['argv'];
        
        // Remove the script name (first argument)
        array_shift($input);

        // Your custom logic here
        $optionValue = null;
        $argument1Value = null;

        // Parse the command line arguments and options manually
        while (!empty($input)) {
            $arg = array_shift($input);

            if ($arg === '--your-option-name') {
                $optionValue = array_shift($input);
            } elseif ($arg === 'argument1-name') {
                $argument1Value = array_shift($input);
            } else {
                // Handle unknown arguments or options here
            }
        }

        // Your custom logic here
        $io->write("Option Value: $optionValue");
        $io->write("Argument 1 Value: $argument1Value");

        return 0; // Return an exit code (0 for success)
    }
}
