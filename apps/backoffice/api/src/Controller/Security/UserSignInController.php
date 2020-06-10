<?php

declare(strict_types = 1);


namespace Cuadrik\Apps\Backoffice\Api\Controller\Security;


use Cuadrik\Backoffice\Users\Application\SignInQuery;
use Cuadrik\Backoffice\Users\Application\SignInQueryHandler;
use Cuadrik\Backoffice\Users\Infrastructure\Projections\SPAUserProjector;
use Cuadrik\Shared\Infrastructure\Symfony\ExtendedController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserSignInController extends ExtendedController
{
    /**
     * @Route("/api/login", defaults={}, name="login")
     * @param Request $request
     * @param SignInQueryHandler $signInQueryHandler
     * @return RedirectResponse
     */
    public function userSignIn(Request $request, SignInQueryHandler $signInQueryHandler): RedirectResponse
    {

        $uuid = $signInQueryHandler->handle(new SignInQuery(
                $request->request->get("username"),
                $request->request->get("password")
            )
        );

        return $this->redirectToRoute('project_user', ['uuid' => $uuid->value()]);

    }

}