<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Infrastructure\Symfony\Service;


use Cuadrik\Crm\Users\Domain\Password;
use Cuadrik\Crm\Users\Domain\PasswordEncoder;
use Cuadrik\Crm\Users\Domain\Username;
use Cuadrik\Crm\Users\Infrastructure\Symfony\SecurityUser;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Cuadrik\Crm\Shared\Domain\Model\UserId;

final class SymfonyEncodePassword implements PasswordEncoder
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