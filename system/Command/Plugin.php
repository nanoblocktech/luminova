<?php
namespace Luminova\Command;
use Luminova\Command\Subscriber;
class Plugin{
    public static function activate($composer)
    {
        $commandNames = [
            'luminova-create', 
            'another-command'
        ];
        foreach ($commandNames as $commandName) {
            $composer->getEventDispatcher()->addSubscriber(new Subscriber($commandName));
        }
    }
}
