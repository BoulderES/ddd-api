<?php
declare(strict_types = 1);


namespace Cuadrik\Crm\Companies\Domain\User;


use Cuadrik\Crm\Shared\Domain\Utils\Exceptions\ExceptionManager;
use Cuadrik\Crm\Shared\Domain\ValueObject\StringValueObject;

final class Email  extends StringValueObject
{

    public function __construct(string $email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            ExceptionManager::throw('Email not valid. ' . get_called_class());

        parent::__construct($email);
    }

}