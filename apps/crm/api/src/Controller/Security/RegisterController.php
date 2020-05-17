<?php
declare(strict_types = 1);


namespace Cuadrik\Apps\Crm\Api\Controller\Security;


use Cuadrik\Crm\Application\User\CreateRegularUserCommand;
use Cuadrik\Crm\Domain\Shared\ExceptionHandler;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Infrastructure\Symfony\Service\TokenAuthenticatedController;
use Cuadrik\Crm\Infrastructure\Symfony\Bus\SymfonyCommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController implements TokenAuthenticatedController
{
    private ExceptionHandler $exceptionHandler;

    public function __construct(ExceptionHandler $exceptionHandler)
    {
        $this->exceptionHandler = $exceptionHandler;
    }

    /**
     * @Route("/api/register", defaults={}, name="create")
     * @param Request $request
     * @param SymfonyCommandBus $bus
     * @return string
     */
    public function register(Request $request, SymfonyCommandBus $bus)
    {
        $userUuid = Userid::random()->value();
        $companyUuid = CompanyId::random()->value();

        $bus->dispatch(new CreateRegularUserCommand(
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