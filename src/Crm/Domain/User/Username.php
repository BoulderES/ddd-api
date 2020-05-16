<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;


use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\BadRequestException;
use Cuadrik\Crm\Domain\Shared\ValueObject\StringValueObject;

final class Username extends StringValueObject
{

    public function __construct(string $username)
    {
        if(null === $username || "" === $username)
            BadRequestException::throw('Username doesn\'t exist in request. ' . get_called_class());

        parent::__construct($username);
    }

}