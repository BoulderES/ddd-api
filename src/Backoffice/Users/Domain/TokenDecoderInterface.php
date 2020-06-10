<?php
declare(strict_types = 1);


namespace Cuadrik\Backoffice\Users\Domain;


use Cuadrik\Shared\Domain\Model\Token;

interface TokenDecoderInterface
{
    public function decode(String $user): Token;

}