<?php

declare(strict_types = 1);


namespace Cuadrik\Shared\Infrastructure\Symfony\EventListener;

use Doctrine\Persistence\Event\LifecycleEventArgs;

class EntitiesPreUpdateListener
{
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if(method_exists($entity, 'preUpdateHandler')){
            $entity->preUpdateHandler();
        }

    }
}