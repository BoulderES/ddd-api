<?php

declare(strict_types = 1);


namespace Cuadrik\Apps\Backoffice\Api\Controller\Security;


use Cuadrik\Backoffice\Users\Application\CreateRegularUserCommand;
use Cuadrik\Shared\Domain\Model\CompanyId;
use Cuadrik\Shared\Domain\Model\UserId;
use Cuadrik\Shared\Infrastructure\Symfony\ExtendedController;
use Cuadrik\Backoffice\Users\Application\CreateRegularUserCommandHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserSignUpController extends ExtendedController
{

    /**
     * @Route("/api/register", defaults={}, name="create")
     * @param Request $request
     * @param CreateRegularUserCommandHandler $createRegularUserCommandHandler
     * @return RedirectResponse
     */
    public function userSignUp(Request $request, CreateRegularUserCommandHandler $createRegularUserCommandHandler): RedirectResponse
    {
        $userUuid = Userid::random()->value();
        $companyUuid = CompanyId::random()->value();

        $createRegularUserCommandHandler->handle(CreateRegularUserCommand::fromArray([
//        $this->dispatch(CreateRegularUserCommand::fromArray([
                'userId'    => $userUuid,
                'companyId' => $companyUuid,
                'username'  => $request->request->get("username"),
                'password'  => $request->request->get("password"),
                'email'     => $request->request->get("email"),
                'photoUrl'  => $request->request->get("photoUrl")
                ]
            )
        );

        return $this->redirectToRoute('project_user', ['uuid' => $userUuid]);

    }

}