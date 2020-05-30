<?php


namespace Cuadrik\Apps\Crm\Api\Controller;


use Broadway\EventDispatcher\CallableEventDispatcher;
use Symfony\Component\Routing\Annotation\Route;

class BroadwayController
{
    /**
     * @Route("/broadway1", defaults={}, name="broadway_1")
     * @param string $uuid
     * @return string
     */
    public function projectUser(string $uuid)
    {
        $eventDispatcher = new CallableEventDispatcher();

        $eventDispatcher->addListener('my_event', function ($arg1, $arg2) {
            echo "Arg1: $arg1\n";
            echo "Arg2: $arg2\n";
        });

        // Dispatch with an array of arguments
        $eventDispatcher->dispatch('my_event', ['one', 'two']);

    }

}