<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\Shared\Service;


use Cuadrik\Crm\Domain\Shared\Model\Token;

interface TokenDecoderInterface
{
    public function decode(String $user): Token;

}