<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;


use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\BadRequestException;
use Cuadrik\Crm\Domain\Shared\ValueObject\StringValueObject;

final class Password extends StringValueObject
{

    public function __construct(string $password)
    {
        if(null === $password || "" === $password)
            BadRequestException::throw('Password can not be empty. ' . get_called_class());

        parent::__construct($password);
    }

}