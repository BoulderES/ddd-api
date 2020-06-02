<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Users\Domain;


use Cuadrik\Crm\Shared\Domain\Model\Token;

interface TokenDecoderInterface
{
    public function decode(String $user): Token;

}