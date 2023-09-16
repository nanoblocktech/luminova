<?php
namespace Luminova\Command;

use Composer\Composer;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\Script\ScriptEvents;
use Luminova\Command\Create;

class Subscriber implements EventSubscriberInterface
{
    private $commandNames;

    public function __construct(array $commandNames)
    {
        $this->commandNames = $commandNames;
    }

    public static function getSubscribedEvents()
    {
        return [
            ScriptEvents::POST_INSTALL_CMD => 'registerCustomCommand',
            ScriptEvents::POST_UPDATE_CMD => 'registerCustomCommand',
        ];
    }

    public function registerCustomCommand($event)
    {
        $composer = $event->getComposer();

        foreach ($this->commandNames as $commandName) {
            $command = null;
            switch ($commandName) {
                case 'luminova-create':
                    $command = new Create();
                    break;
                case 'another-command':
                    $command = new AnotherCommand();
                    break;
                default:
                    break;
            }

            if ($command !== null) {
                $composer->getEventDispatcher()->addSubscriber($command, $commandName);
            }
        }
    }
}