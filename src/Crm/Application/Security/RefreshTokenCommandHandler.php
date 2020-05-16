<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Application\Security;

use Cuadrik\Crm\Domain\Shared\Bus\Command\CommandHandler;
use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\UnauthorizedException;
use Cuadrik\Crm\Domain\Shared\Service\TokenDecoderInterface;
use Cuadrik\Crm\Domain\Shared\Service\TokenEncoderInterface;
use Cuadrik\Crm\Domain\User\UserRepositoryInterface;

class RefreshTokenCommandHandler implements CommandHandler
{

    private UserRepositoryInterface $userRepository;
    private TokenEncoderInterface $tokenEncoder;
    private TokenDecoderInterface $tokenDecoder;

    public function __construct(UserRepositoryInterface $userRepository, TokenEncoderInterface $tokenEncoder, TokenDecoderInterface $tokenDecoder)
    {
        $this->userRepository = $userRepository;
        $this->tokenEncoder = $tokenEncoder;
        $this->tokenDecoder = $tokenDecoder;
    }

    public function __invoke(RefreshTokenCommand $refreshToken)
    {
        $user = $this->userRepository->userByToken($refreshToken->getToken());
        if(!$user)
            UnauthorizedException::throw('Unauthorized token. ' . get_called_class());

        $uuid = $user->uuid();
        $username = $user->username();
        $password = $user->password();
        $roles = $user->roles();

        $token = new Token( $this->tokenEncoder->encodeToken( $uuid, $username, $password, $roles ) );

        $user->refreshToken($token);

        $this->userRepository->save($user);

    }
}