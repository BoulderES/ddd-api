<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;


use Cuadrik\Crm\Shared\Domain\Model\Token;

interface TokenDecoderInterface
{
    public function decode(String $user): Token;

}