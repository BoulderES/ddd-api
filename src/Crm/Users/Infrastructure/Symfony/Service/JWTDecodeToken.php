<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Infrastructure\Symfony\Service;


use Cuadrik\Crm\Shared\Domain\Model\Token;
use Cuadrik\Crm\Users\Domain\TokenDecoderInterface;
use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;

final class JWTDecodeToken implements TokenDecoderInterface
{

    private JWTEncoderInterface $jwt_encoder;

    public function __construct(JWTEncoderInterface $jwt_encoder)
    {
        $this->jwt_encoder = $jwt_encoder;
    }

    public function decode(String $token): Token
    {
        try {

            return new Token($token, $this->jwt_encoder->decode($token));

        } catch (\Exception $e) {
            ExceptionManager::throw('This action needs a valid token! ' . $e->getMessage(), 401);
        }
    }
}