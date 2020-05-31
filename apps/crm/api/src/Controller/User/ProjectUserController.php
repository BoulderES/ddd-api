<?php

declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\User;


use Cuadrik\Crm\Companies\Application\User\GetUserQuery;
use Cuadrik\Crm\Companies\Application\User\GetUserQueryHandler;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\SymfonyQueryBus;
use Cuadrik\Crm\Companies\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Crm\Companies\Infrastructure\Projections\SPAUserProjector;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\ExtendedController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ProjectUserController extends ExtendedController implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/project-user/{uuid}", defaults={}, name="project_user")
     * @param string $uuid
     * @param GetUserQueryHandler $getUserQueryHandler
     * @param SymfonyQueryBus $bus
     * @return JsonResponse
     */
    public function projectUser(string $uuid, GetUserQueryHandler $getUserQueryHandler, SymfonyQueryBus $bus): JsonResponse
    {
        if(!$user = $getUserQueryHandler->handle(new GetUserQuery($uuid)))
            ExceptionManager::throw('User not found!');

        return new JsonResponse(
            SPAUserProjector::execute($user)
        );
    }
}