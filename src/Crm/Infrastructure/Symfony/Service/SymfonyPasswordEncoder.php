<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Infrastructure\Symfony\Service;


use Cuadrik\Crm\Domain\User\Password;
use Cuadrik\Crm\Domain\User\PasswordEncoder;
use Cuadrik\Crm\Domain\User\Username;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Cuadrik\Crm\Domain\Shared\Model\UserId;

final class SymfonyPasswordEncoder implements PasswordEncoder
{
    private EncoderFactoryInterface $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory)
    {
        $this->encoderFactory = $encoderFactory;
    }

    public function encodePassword(UserId $userId, Username $username, Password $plainPassword): string
    {
        $user = new SecurityUser($userId, $username);

        $encoder = $this->encoderFactory->getEncoder($user);

        return $encoder->encodePassword($plainPassword->value(), $user->getSalt());
    }

    public function isPasswordValid(UserId $userId, Username $username, Password $password, Password $plainPassword): bool
    {

        $user = new SecurityUser($userId, $username, $password);

        if (null === $user->getPassword()) {
            return false;
        }

        $encoder = $this->encoderFactory->getEncoder($user);

        return $encoder->isPasswordValid($user->getPassword(), $plainPassword->value(), $user->getSalt());
    }

}