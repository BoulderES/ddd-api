<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Companies\Application\User\CreateRegularUserCommand;
use Cuadrik\Crm\Companies\Application\User\CreateRegularUserCommandHandler;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    /**
     * @Route("/api/register", defaults={}, name="create")
     * @param Request $request
     * @param SymfonyCommandBus $bus
     * @param CreateRegularUserCommandHandler $createRegularUserCommandHandler
     * @return string
     */
    public function register(Request $request, CreateRegularUserCommandHandler $createRegularUserCommandHandler, SymfonyCommandBus $bus)
    {
        $userUuid = Userid::random()->value();
        $companyUuid = CompanyId::random()->value();

        $createRegularUserCommandHandler->__invoke(new CreateRegularUserCommand(
                $userUuid,
                $companyUuid,
                $request->request->get("username"),
                $request->request->get("password"),
                $request->request->get("email"),
                $request->request->get("photoUrl")
            )
        );


        return $this->redirectToRoute('view_user', ['uuid' => $userUuid]);

    }

}