<?php

declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Application;

use Cuadrik\Shared\Domain\Bus\Command\CommandHandler;
use Cuadrik\Shared\Domain\Model\Token;
use Cuadrik\Backoffice\Users\Domain\TokenDecoderInterface;
use Cuadrik\Backoffice\Users\Domain\TokenEncoderInterface;
use Cuadrik\Backoffice\Users\Domain\UserRepositoryInterface;
use Cuadrik\Shared\Domain\Model\UserId;
use Cuadrik\Shared\Domain\Utils\Exceptions\ExceptionManager;

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