<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Application\Security;

use Cuadrik\Crm\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Crm\Shared\Domain\Model\Token;
use Cuadrik\Crm\Companies\Domain\User\TokenDecoderInterface;
use Cuadrik\Crm\Companies\Domain\User\TokenEncoderInterface;
use Cuadrik\Crm\Companies\Domain\User\UserRepositoryInterface;
use Cuadrik\Crm\Shared\Domain\Model\UserId;
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

    public function handle(RefreshTokenCommand $refreshToken): UserId
    {
        $token = $this->tokenDecoder->decode($refreshToken->getToken());

        $user = $this->userRepository->userByToken($token->value());
        if(!$user)
            ExceptionManager::throw('Unauthorized token. ' . get_called_class(), 401);

        $token = new Token(
            $this->tokenEncoder->encodeToken(
                $user->uuid(),
                $user->username(),
                $user->password(),
                $user->roles()
            )
        );

        $user->refreshToken($token);

        $this->userRepository->save($user);

        return $user->uuid();
    }
}