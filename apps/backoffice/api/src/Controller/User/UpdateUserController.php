<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Backoffice\Api\Controller\User;

use Cuadrik\Backoffice\Users\Application\UpdateUserCommand;
use Cuadrik\Backoffice\Users\Application\UpdateUserCommandHandler;
use Cuadrik\Shared\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Cuadrik\Backoffice\Users\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Shared\Infrastructure\Symfony\ExtendedController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateUserController extends ExtendedController implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/update-user/{uuid}", defaults={}, name="update_user")
     * @param Request $request
     * @param string $uuid
     * @param UpdateUserCommandHandler $updateUserCommandHandler
     * @return RedirectResponse
     */
    public function updateUser(Request $request, string $uuid, UpdateUserCommandHandler $updateUserCommandHandler): RedirectResponse
    {
        $updateUserCommandHandler->handle(new UpdateUserCommand(
                $uuid,
                $request->request->get("username"),
                $request->request->get("password"),
                $request->request->get("email"),
                $request->request->get("photoUrl"),
                $request->request->get("firstName"),
                $request->request->get("lastName"),
            )
        );

        return $this->redirectToRoute('project_user', ['uuid' => $uuid]);
    }
}