<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Infrastructure\Symfony\Service;


use Cuadrik\Crm\Domain\Shared\Model\Token;
use Cuadrik\Crm\Domain\Shared\Service\TokenDecoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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

            throw new AccessDeniedHttpException( $e->getMessage());
        }
    }
}