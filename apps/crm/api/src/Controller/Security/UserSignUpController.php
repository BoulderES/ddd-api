<?php

declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Users\Application\CreateRegularUserCommand;
use Cuadrik\Crm\Shared\Domain\Model\CompanyId;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
use Cuadrik\Crm\Shared\Infrastructure\Symfony\ExtendedController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserSignUpController extends ExtendedController
{

    /**
     * @Route("/api/register", defaults={}, name="create")
     * @param Request $request
     * @return RedirectResponse
     */
    public function userSignUp(Request $request): RedirectResponse
    {
        $userUuid = Userid::random()->value();
        $companyUuid = CompanyId::random()->value();

        $this->dispatch(new CreateRegularUserCommand(
                $userUuid,
                $companyUuid,
                $request->request->get("username"),
                $request->request->get("password"),
                $request->request->get("email"),
                $request->request->get("photoUrl")
            )
        );

        return $this->redirectToRoute('project_user', ['uuid' => $userUuid]);

    }

}