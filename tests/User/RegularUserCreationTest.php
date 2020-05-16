<?php

namespace Cuadrik\Tests\User;

use Cuadrik\Crm\Application\User\CreateRegularUserCommand;
use Cuadrik\Crm\Domain\Shared\Model\CompanyId;
use Cuadrik\Crm\Domain\Shared\Model\UserId;
use Cuadrik\Crm\Domain\User\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class RegularUserCreationTest extends KernelTestCase
{
    private $bus;
    private $tokenDecoder;

    protected function setUp()
    {
        self::bootKernel();
        $this->bus = self::$container->get('Cuadrik\Crm\Domain\Shared\Bus\Command\CommandBus');
        $this->tokenDecoder = self::$container->get('Cuadrik\Crm\Infrastructure\Symfony\Service\JWTDecodeToken');
    }

    /** @test
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

        $user = $this->bus->dispatch(new CreateRegularUserCommand(
                $uuid,
                $companyUuid,
                $username,
                $password,
                $email,
                $photoUrl
            )
        );

        try {
            $this->tokenDecoder->decode($user->token()->value());
        } catch (\Exception $e) {
            throw new AccessDeniedHttpException('This action needs a valid token! ' . $user->token()->value());
        }

        $this->assertInstanceOf(User::class, $user);

    }

}
