<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Domain\User;


use Cuadrik\Crm\Domain\Shared\Service\ExceptionFactory\BadRequestException;
use Cuadrik\Crm\Domain\Shared\ValueObject\StringValueObject;

final class Email  extends StringValueObject
{

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            BadRequestException::throw('Email not valid. ' . get_called_class());

        parent::__construct($email);
    }

}