<?php

namespace Cuadrik\Tests\User;

use Cuadrik\Backoffice\Users\Application\SignInQuery;
use Cuadrik\Backoffice\Users\Application\CreateRegularUserCommand;
use Cuadrik\Backoffice\Users\Application\GetUserQuery;
use Cuadrik\Shared\Domain\Model\CompanyId;
use Cuadrik\Shared\Domain\Model\UserId;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Transport\InMemoryTransport;

class RegularUserCreationTest extends KernelTestCase
{
//    private $commandBus;
//    private $queryBus;
//    private $tokenDecoder;
    private $createUserCommandHandler;
    private $getUserQueryHandler;

    protected function setUp()
    {
        self::bootKernel();
//        $this->commandBus = self::$container->get('Cuadrik\Shared\Domain\Bus\SyncCommand\CommandBus');
//        $this->queryBus = self::$container->get('Cuadrik\Shared\Domain\Bus\Query\QueryBus');
//        $this->bus = self::$container->get('Cuadrik\Shared\Infrastructure\Symfony\Bus\SymfonyCommandBus.php');
//        $this->tokenDecoder = self::$container->get('Cuadrik\Backoffice\Users\Infrastructure\Symfony\Service\JWTDecodeToken');
        $this->createUserCommandHandler = self::$container->get('Cuadrik\Backoffice\Users\Application\User\CreateRegularUserCommandHandler');
        $this->getUserQueryHandler = self::$container->get('Cuadrik\Backoffice\Users\Application\GetUserQueryHandler');
    }

    /**
     * @test
     */
    public function CreateRegularUserTest()
    {
//        $client = static::createClient();
        $randomize = rand(0,9999999);

        $uuid = Userid::random()->value();
        $companyUuid = CompanyId::random()->value();
        $username = "username$randomize";
        $password = "1234";
        $email = "email$randomize@email.email";
        $photoUrl = "$randomize.jpg";

        $userCommand = $this->createUserCommandHandler->__invoke(new CreateRegularUserCommand(
                $uuid,
                $companyUuid,
                $username,
                $password,
                $email,
                $photoUrl
            )
        );

        $userQuery = $this->getUserQueryHandler->__invoke(new GetUserQuery($uuid));

        $this->assertEquals($userCommand, $userQuery);








//        $user = $this->queryBus->query(new SignInQuery(
//                "admin",
//                "admin"
//            )
//        );





//        /* @var InMemoryTransport $transport */
//        $transport = self::$container->get('messenger.transport.query');
//        var_export(get_class_methods($transport->get()));
//        var_export(json_encode($transport));

//        /* @var InMemoryTransport $transport */
//        $transport = self::$container->get('messenger.transport.command');
//        $this->assertCount(1, $transport->get());
//        dd($transport);

    }

}
