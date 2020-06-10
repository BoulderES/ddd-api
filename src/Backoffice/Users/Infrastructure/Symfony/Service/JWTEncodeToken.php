<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Infrastructure\Symfony\Service;


use Cuadrik\Backoffice\Users\Infrastructure\Symfony\SecurityUser;
use Cuadrik\Shared\Domain\Model\UserId;
use Cuadrik\Backoffice\Users\Domain\TokenEncoderInterface;
use Cuadrik\Backoffice\Users\Domain\Username;
use Cuadrik\Backoffice\Users\Domain\Password;
use Cuadrik\Backoffice\Users\Domain\Roles;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class JWTEncodeToken implements TokenEncoderInterface
{

    private JWTEncoderInterface $jwt_encoder;

    private EventDispatcherInterface $dispatcher;

    public function __construct(JWTEncoderInterface $jwt_encoder, EventDispatcherInterface $dispatcher)
    {
        $this->jwt_encoder = $jwt_encoder;
        $this->dispatcher = $dispatcher;
    }

    public function encodeToken(UserId $userId, Username $username, Password $password, Roles $roles): String
    {
        $user = new SecurityUser($userId, $username, $password, $roles);
        
        $jwt_manager = new JWTManager($this->jwt_encoder,$this->dispatcher);

        return $jwt_manager->create($user);
    }
}