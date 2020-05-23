<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\User;

use Cuadrik\Crm\Companies\Application\User\UpdateUserCommand;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Cuadrik\Crm\Companies\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UpdateUserController extends AbstractController implements TokenAuthenticatedController
{

    /**
     * @Route("/api/auth/update-user/{uuid}", defaults={}, name="view_user")
     * @param string $uuid
     * @param SymfonyCommandBus $bus
     * @return string
     */
    public function updateUser(Request $request, string $uuid, SymfonyCommandBus $bus)
    {
        $bus->dispatch(new UpdateUserCommand(
                $uuid,
                $request->request->get("username"),
                $request->request->get("password"),
                $request->request->get("email"),
                $request->request->get("photoUrl")
            )
        );

        return $this->redirectToRoute('view_user', ['uuid' => $uuid]);
    }
}