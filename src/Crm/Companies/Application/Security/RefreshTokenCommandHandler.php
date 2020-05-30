<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\Security;

use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Crm\Shared\Domain\Model\Token;
use Cuadrik\Crm\Companies\Domain\User\TokenDecoderInterface;
use Cuadrik\Crm\Companies\Domain\User\TokenEncoderInterface;
use Cuadrik\Crm\Companies\Domain\User\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;

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

    public function __invoke(RefreshTokenCommand $refreshToken): void
    {
        $this->handle($refreshToken);
    }

    public function handle(RefreshTokenCommand $refreshToken)
    {
        $user = $this->userRepository->userByToken($refreshToken->getToken());
        if(!$user)
            ExceptionManager::throw('Unauthorized token. ' . get_called_class(), 401);

        $uuid = $user->uuid();
        $username = $user->username();
        $password = $user->password();
        $roles = $user->roles();

        $token = new Token( $this->tokenEncoder->encodeToken( $uuid, $username, $password, $roles ) );

        $user->refreshToken($token);

        $this->userRepository->save($user);

    }
}