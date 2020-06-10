<?php

declare(strict_types = 1);


namespace Cuadrik\Apps\Backoffice\Api\Controller\User;


use Cuadrik\Backoffice\Users\Application\GetUserQuery;
use Cuadrik\Backoffice\Users\Application\GetUserQueryHandler;
use Cuadrik\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Shared\Infrastructure\Symfony\Bus\SymfonyQueryBus;
use Cuadrik\Backoffice\Users\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Backoffice\Users\Infrastructure\Projections\SPAUserProjector;
use Cuadrik\Shared\Infrastructure\Symfony\ExtendedController;
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